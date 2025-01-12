<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Event;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\CourseController;
use App\Models\CourseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminTimetableController;
use App\Models\Timetable;
use Dompdf\Options;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Log;
use App\Models\MinorRegistration;
use App\Models\News;
use App\Models\ProgramStructure;
class StudentController extends Controller
{
    // Show the student dashboard
    public function dashboard()
    {
        $student_id = Auth::id();
        $student = Student::where('user_id', $student_id)->firstOrFail();

                // Check if student exists and has a program_id
        if (!$student || !$student->program_id) {
            \Log::warning('Student or program_id not found', ['user_id' => $student_id]);
            return view('student.dashboard')->with('error', 'Program information not found');
        }

        $programStructure = ProgramStructure::where('program_id', $student->program_id)
        ->latest('academic_year')
        ->first();

        // Get student's registered courses
        $registeredCourses = CourseRegistration::where('student_id', $student_id)
            ->with('course')
            ->get();

        // display events that are ongoing
        $events = Event::whereDate('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->take(5)
            ->get();

        // Get available courses for registration
        $availableCourses = Course::whereNotIn('id', $registeredCourses->pluck('course_id'))
            ->get();

        $latestNews = News::with('user')
            ->latest()
            ->take(5)
            ->get();




        return view('student.dashboard', compact(
            'registeredCourses',
            'events',
            'availableCourses',
            'student',
            'latestNews',
            'programStructure'
        ));
    }

    // Method for registering a course
    public function registerCourse(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        // Find the student by ID
        $student = Student::findOrFail($id);

        // Register the course for the student
        $student->courses()->attach($validatedData['course_id']); // Assuming a many-to-many relationship

        return redirect()->route('student.dashboard', ['id' => $student->id])
            ->with('success', 'Registered for the course successfully.');
    }

    public function profile()
    {
        $student = Student::with(['program', 'faculty'])  // Eager load both program and faculty
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('student.profile', compact('student'));
    }

    public function download()
    {
        $student = auth()->user()->student;
        $programStructure = ProgramStructure::where('program_id', $student->program_id)
        ->latest('academic_year')
            ->first();

        if (!$programStructure) {
            return back()->with('error', 'Program structure not found');
        }

        return response()->download(storage_path('app/public/' . $programStructure->pdf_path));
    }



    //for student to update their profile
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        Log::info('Student found:', ['student' => $student]);
        return view('student.profile.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        // Find student by id
        $student = Student::findOrFail($id);
        Log::info('Found student for update:', ['student_id' => $student->id]);

        try {
            $validatedData = $request->validate([
                'email' => 'required|email',
                'matric_number' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Replace the existing photo upload code with this:
            if ($request->hasFile('photo')) {
                // Delete old photo if it exists
                if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                    Storage::disk('public')->delete($student->photo);
                }

                // Store new photo
                $path = $request->file('photo')->store('profile_photos', 'public');
                $validatedData['photo'] = $path;
            }

            $student->update($validatedData);

            return redirect()->route('students.profile', $student->id)->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $student = Student::findOrFail($id);
            return view('student.profile',
                compact('student')
            );
        } catch (\Exception $e) {
            \Log::error('Error showing student profile: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Student profile not found');
        }
    }

    public function showMinorRegistration($id) {
        $student = Student::findOrFail($id); // Fetch the student using the provided ID
        $minorCourses = Course::where('type', 'minor')->get(); // Fetch minor courses from the database
        return view('student.minor-course-registration', compact('student', 'minorCourses'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }

    public function showEnrollmentStatus(Request $request)
    {
        // Get the authenticated user's student record
        $student = Auth::user()->student;
        $student_id = $student->id; // This is the actual student ID

        \Log::info('Student Details:', [
            'user_id' => Auth::id(),
            'student_id' => $student_id
        ]);

        try {
            // Fetch course requests using student_id
            $courseRequests = CourseRequest::with(['course'])
                ->where('student_id', $student_id)
                ->latest()
                ->paginate(10);

            // Fetch minor registrations using student_id
            $minorRegistrations = MinorRegistration::where('student_id', $student_id)
                ->latest()
                ->paginate(10, ['*'], 'minor_page');

            // Log the results
            \Log::info('Query Results:', [
                'course_requests_count' => $courseRequests->count(),
                'minor_registrations_count' => $minorRegistrations->count()
            ]);

            return view('student.status-enrollments', compact('courseRequests', 'minorRegistrations'));
        } catch (\Exception $e) {
            \Log::error('Error in showEnrollmentStatus:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'An error occurred while fetching enrollment status.');
        }
    }

    public function getStatus($id)
{
    $student = Student::find($id);
    if (!$student) {
        return response()->json(['error' => 'Student not found'], 404);
    }

    return response()->json(['is_scholarship' => $student->is_scholarship]); // Assuming 'scholarship_status' is the correct field
}

    public function showTimetable()
    {
        $student = Auth::user()->student;
        $studentId = $student->id;


        try {
            // Get approved major courses with groups
            $majorTimetables = CourseRequest::with(['course', 'group'])
                ->where('student_id', $studentId)
                ->where('status', 'approved')
                ->get()
                ->map(function ($courseRequest) {
                    // Debug log for group data
                    \Log::info('Processing course request:', [
                        'course_code' => $courseRequest->course_code,
                        'group_id' => $courseRequest->group_id,
                        'group' => $courseRequest->group
                    ]);

                    // Safely access group properties with null coalescing
                    return (object)[
                        'course_code' => $courseRequest->course_code,
                        'course_name' => $courseRequest->course->course_name ?? 'Unknown Course',
                        'day_of_week' => $courseRequest->group?->day_of_week ?? 'TBA',
                        'start_time' => $courseRequest->group?->time ?? '08:00:00',
                        'end_time' => $courseRequest->group?->time ?
                            date('H:i:s', strtotime($courseRequest->group->time . ' +2 hours')) : '10:00:00',
                        'place' => $courseRequest->group?->place ?? 'TBA',
                        'group_name' => $courseRequest->group?->name ?? null,
                        'source' => 'major'
                    ];
                });


            // Get approved minor courses
            $minorTimetables = MinorRegistration::with(['course'])
                ->where('student_id', $studentId)
                ->where('status', 'approved')
                ->get()
                ->map(function ($registration) {
                                        // Debug log for group data
                    \Log::info('Processing course request:', [
                        'course_code' => $registration->course_code,
                        'group_id' => $registration->group_id,
                        'group_data' => $registration->group

                    ]);
                    return (object)[
                        'course_code' => $registration->course_code,
                        'course_name' => $registration->course_name,
                        'day_of_week' => 'Monday', // You might want to add these fields to minor_registrations table
                        'start_time' => '08:00:00',
                        'end_time' => '10:00:00',
                        'place' => $registration->place,
                        'source' => 'minor'
                    ];
                });

            // Debug logging
            \Log::info('Timetables Debug:', [
                'student_id' => $studentId,
                'major_count' => $majorTimetables->count(),
                'minor_count' => $minorTimetables->count(),
                'major_samples' => $majorTimetables->map(function ($t) {
                    return [
                        'course_code' => $t->course_code,
                        'day_of_week' => $t->day_of_week,
                        'start_time' => $t->start_time,
                        'group_name' => $t->group_name
                    ];
                })->toArray()
            ]);

            // Combine both collections
            $timetables = $majorTimetables->concat($minorTimetables);

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            return view('student.timetables.show', compact('timetables', 'days'));
        } catch (\Exception $e) {
            \Log::error('Error in showTimetable:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Unable to load timetable. Please try again later.');
        }
    }

    public function exportTimetable()
    {
        $student_id = Auth::id();

        // Fetch approved major course codes
        $approvedMajorCourses = CourseRequest::where('student_id', $student_id)
            ->where('status', 'approved')
            ->pluck('course_code');

        // Fetch approved minor course codes
        $approvedMinorCourses = MinorRegistration::where('student_id', $student_id)
            ->where('status', 'approved')
            ->pluck('course_code');

        // Merge both course codes
        $allApprovedCourses = $approvedMajorCourses->concat($approvedMinorCourses);

        // Retrieve timetables based on all approved course codes
        $timetables = Timetable::whereIn('course_code', $allApprovedCourses)->get();

        // Rest of your export code...
    }

    public function showProgramStructure()
    {
        $student = auth()->user()->student;
        $programStructure = ProgramStructure::where('program_name', $student->programme)
            ->where('is_active', true)
            ->latest('academic_year')
            ->first();

        if (!$programStructure) {
            return back()->with('error', 'Program structure not found for your program.');
        }

        return view('student.program-structure', compact('programStructure', 'student'));
    }


}
