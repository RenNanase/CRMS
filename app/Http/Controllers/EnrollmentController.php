<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseRequest;
use App\Models\Timetable;
use App\Models\Group;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'group_id' => 'required|exists:groups,id',
                'course_id' => 'required|exists:courses,id',
            ]);

            // Check if group is full
            $group = Group::findOrFail($request->group_id);
            if ($group->enrollments()->count() >= $group->max_students) {
                return response()->json([
                    'success' => false,
                    'message' => 'This group is already full'
                ], 400);
            }

            // Check for existing enrollment
            $existingEnrollment = Enrollment::where([
                'student_id' => $request->student_id,
                'course_id' => $request->course_id,
            ])->first();

            if ($existingEnrollment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Student is already enrolled in this course'
                ], 400);
            }

            $enrollment = Enrollment::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment successful',
                'enrollment' => $enrollment
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Enrollment failed: ' . $e->getMessage()
            ], 500);
        }
    }


    public function approved()
    {
        $approvedEnrollments = DB::table('course_requests')
            ->join('courses', 'course_requests.course_id', '=', 'courses.id')
            ->select('course_requests.id', 'course_requests.student_name', 'courses.course_name as course_name',
            'course_requests.status', 'course_requests.created_at','course_requests.course_code', 'course_requests.matric_number')
            ->where('course_requests.status', 'approved')
            ->paginate(10); // Changed from get() to paginate(10)

        return view('admin.enrollments.approved', compact('approvedEnrollments'));
    }

    public function rejected()
    {
        $rejectedEnrollments = DB::table('course_requests')
            ->join('courses', 'course_requests.course_id', '=', 'courses.id')
            ->select('course_requests.id', 'course_requests.student_name', 'courses.course_name as course_name',
            'course_requests.status', 'course_requests.created_at','course_requests.course_code', 'course_requests.matric_number')
            ->where('course_requests.status', 'rejected')
            ->paginate(10); // Changed from get() to paginate(10)

        return view('admin.enrollments.rejected', compact('rejectedEnrollments'));
    }

    public function showStatus(Request $request): View
    {
        // Get the authenticated student's ID
        $studentId = auth()->user()->id;

        // Fetch enrollment requests for the current student with pagination
        $enrollments = CourseRequest::with(['student', 'course'])
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Ensure you are using paginate here

        return view('student.enrollment-status', compact('enrollments'));
    }

    public function showEnrollmentStatus(Request $request)
    {
        $studentId = auth()->user()->student->id;

        // Fetch course requests (major courses)
        $courseRequests = CourseRequest::with(['course'])
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // When a major course is approved, add it to timetables
        foreach ($courseRequests as $request) {
            if ($request->status === 'approved') {
                // Find the timetable entry for this course
                $timetableEntry = Timetable::where('course_code', $request->course_code)->first();

                if ($timetableEntry) {
                    // Update or create a timetable entry for this student
                    Timetable::updateOrCreate(
                        [
                            'course_code' => $request->course_code,
                            'student_id' => $studentId
                        ],
                        [
                            'course_name' => $request->course->course_name,
                            'lecturer_id' => $timetableEntry->lecturer_id,
                            'day_of_week' => $timetableEntry->day_of_week,
                            'start_time' => $timetableEntry->start_time,
                            'end_time' => $timetableEntry->end_time,
                            'place' => $timetableEntry->place,
                            'type' => 'major'
                        ]
                    );
                }
            }
        }

        // Fetch minor registrations
        $minorRegistrations = MinorRegistration::where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // When a minor course is approved, add it to timetables
        foreach ($minorRegistrations as $registration) {
            if ($registration->status === 'approved') {
                // Find the timetable entry for this course
                $timetableEntry = Timetable::where('course_code', $registration->course_code)->first();

                if ($timetableEntry) {
                    // Update or create a timetable entry for this student
                    Timetable::updateOrCreate(
                        [
                            'course_code' => $registration->course_code,
                            'student_id' => $studentId
                        ],
                        [
                            'course_name' => $registration->course_name,
                            'lecturer_id' => $timetableEntry->lecturer_id,
                            'day_of_week' => $timetableEntry->day_of_week,
                            'start_time' => $timetableEntry->start_time,
                            'end_time' => $timetableEntry->end_time,
                            'place' => $timetableEntry->place,
                            'type' => 'minor'
                        ]
                    );
                }
            }
        }

        // Log the data for debugging
        \Log::info('Course Requests:', ['data' => $courseRequests->toArray()]);
        \Log::info('Minor Registrations:', ['data' => $minorRegistrations->toArray()]);

        return view('student.status-enrollments', compact('courseRequests', 'minorRegistrations'));
    }


}
