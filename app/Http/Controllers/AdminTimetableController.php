<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\Course;
use App\Models\Place;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminTimetableController extends Controller
{
    public function index(Request $request)
    {
        $query = Timetable::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $timetables = $query->get();
        // Make sure to include the type field when loading courses
        $courses = Course::with('lecturers')->select(['id', 'course_code', 'course_name', 'type'])->get();
        $places = Place::all();

        return view('admin.timetables.index', compact('courses', 'places', 'timetables'));
    }

    public function store(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'course_id' => 'required|exists:courses,id',
                'lecturer_id' => 'required|exists:lecturers,id',
                'day_of_week' => 'required|string',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'place' => 'required|string',
            ]);

            $course = Course::findOrFail($request->course_id);

            // Format times
            $start_time = Carbon::createFromFormat('H:i', $request->start_time)->toTimeString();
            $end_time = Carbon::createFromFormat('H:i', $request->end_time)->toTimeString();

            $timetable = Timetable::create([
                'course_id' => $request->course_id,
                'lecturer_id' => $request->lecturer_id,
                'course_code' => $course->course_code,
                'course_name' => $course->course_name,
                'day_of_week' => $request->day_of_week,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'place' => $request->place,
                'type' => $course->type,
            ]);

            return redirect()->route('admin.timetables.index')
            ->with('success', 'Timetable created successfully.');
        } catch (\Exception $e) {
            \Log::error('Timetable creation error:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);

            return redirect()->route('admin.timetables.index')
            ->with('error', 'Failed to create timetable: ' . $e->getMessage());
        }
    }

    public function showTimetables()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        try {
            // Get all timetables without any filtering
            $timetables = Timetable::with(['course', 'lecturer'])
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();

            // Return the admin timetable view
            return view('admin.timetables.show', compact('timetables', 'days'));
        } catch (\Exception $e) {
            \Log::error('Error in admin showTimetables:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Error loading timetables.');
        }
    }
}
