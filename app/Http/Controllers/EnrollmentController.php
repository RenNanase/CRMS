<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CourseRequest;
use App\Models\Timetable;

class EnrollmentController extends Controller
{
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




    public function enroll(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'date' => 'required|date',
            'time' => 'required|time',
            'place' => 'required|string',
        ]);

        // Enrollment logic here...
        // Ensure you have the student ID and course details
        $studentId = auth()->id(); // Assuming you're using authentication
        $courseCode = $request->input('course_code'); // Adjust as necessary
        $courseName = $request->input('course_name'); // Adjust as necessary

        $timetable = new Timetable();
        $timetable->student_id = $studentId;
        $timetable->course_code = $courseCode;
        $timetable->course_name = $courseName;
        $timetable->date = $request->input('date');
        $timetable->time = $request->input('time');
        $timetable->place = $request->input('place');
        $timetable->save();

        // Redirect or return response
    }

}
