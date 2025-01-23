<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Course;
use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Events\EnrollmentUpdated;

class GroupController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $groups = Group::with(['course' => function($query) {
            $query->join('timetables', 'courses.id', '=', 'timetables.course_id')
                  ->select('courses.*', 'timetables.course_code', 'timetables.place');
        }])
        ->withCount('enrollments')
        ->get();

        return view('admin.groups.index', compact('groups', 'courses'));
    }

    public function getFormData()
    {
        try {
            // Get courses with their timetable information
            $courses = Course::join('timetables', 'courses.id', '=', 'timetables.course_id')
                ->select([
                    'courses.id',
                    'timetables.course_name',
                    'timetables.course_code',
                    'timetables.day_of_week',
                    'timetables.start_time',
                    'timetables.end_time',
                    'timetables.place',
                    'timetables.type'
                ])
                ->get()
                ->map(function($course) {
                    return [
                        'id' => $course->id,
                        'course_name' => $course->course_name,
                        'course_code' => $course->course_code,
                        'day_of_week' => $course->day_of_week,
                        'start_time' => $course->start_time,
                        'end_time' => $course->end_time,
                        'place' => $course->place,
                        'type' => $course->type
                    ];
                });

            \Log::info('Fetched courses with timetable:', $courses->toArray());

            return response()->json([
                'courses' => $courses
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to fetch form data: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch form data'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'name' => 'required|string|max:255',
                'max_students' => 'required|integer|min:1',
                'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
                'time' => 'required|date_format:H:i:s',
            ]);

            // Check for existing group with same schedule
            $existingGroup = Group::where('course_id', $validated['course_id'])
                ->where('day_of_week', $validated['day_of_week'])
                ->where('time', $validated['time'])
                ->first();

            if ($existingGroup) {
                return response()->json([
                    'success' => false,
                    'message' => 'A group already exists for this course at the specified time'
                ], 400);
            }

            $group = Group::create($validated);

            // Broadcast the update
            $this->broadcastEnrollmentUpdate($group->id);

            return response()->json([
                'success' => true,
                'message' => 'Group created successfully',
                'group' => $group->load('course')
            ], 201);

        } catch (\Exception $e) {
            \Log::error('Group creation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to create group: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Group $group)
    {
        try {
            $group->delete();
            return response()->json([
                'success' => true,
                'message' => 'Group deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete group'
            ], 500);
        }
    }

    public function getGroupsByCourse($courseId)
    {
        try {
            \Log::info('Fetching groups for course ID: ' . $courseId);

            $course = Course::findOrFail($courseId);
            $groups = Group::where('course_id', $courseId)
                ->select(['id', 'name', 'day_of_week', 'time', 'max_students'])
                ->withCount(['enrollments as current_students'])
                ->get();

            $timetable = Timetable::where('course_id', $courseId)->first();

            $formattedGroups = $groups->map(function ($group) use ($timetable) {
                return [
                    'id' => $group->id,
                    'name' => $group->name,
                    'day_of_week' => $timetable ? $timetable->day_of_week : $group->day_of_week,
                    'time' => $timetable ? $timetable->start_time : $group->time,
                    'place' => $timetable ? $timetable->place : 'TBA',
                    'max_students' => $group->max_students,
                    'current_students' => $group->current_students,
                    'availability' => "{$group->current_students}/{$group->max_students}",
                    'is_full' => $group->current_students >= $group->max_students
                ];
            });

            return response()->json([
                'success' => true,
                'course' => [
                    'id' => $course->id,
                    'code' => $course->course_code,
                    'name' => $course->course_name
                ],
                'groups' => $formattedGroups
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getGroupsByCourse: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function broadcastEnrollmentUpdate($groupId)
    {
        $group = Group::withCount('enrollments')->find($groupId);
        event(new EnrollmentUpdated(
            $groupId,
            $group->enrollments_count,
            $group->max_students
        ));
    }
}
