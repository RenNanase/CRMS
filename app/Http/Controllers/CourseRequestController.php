<?php
namespace App\Http\Controllers;

use App\Models\CourseRequest;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\MajorCourseRegistration;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationPeriod;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use App\Models\Group;
use Illuminate\Support\Facades\Log;

class CourseRequestController extends Controller
{
    public function index(Request $request)
    {
        // Keep your existing index code
        $activeMajorPeriod = RegistrationPeriod::major()->active()->first();

        if (!$activeMajorPeriod) {
            return redirect()->back()->with('error', 'Major course registration is currently closed.');
        }

        $query = CourseRequest::with(['course'])
            ->when($request->filled('status'), function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->when($request->filled('program'), function ($query) use ($request) {
                return $query->where('program', $request->program);
            })
            ->when($request->filled('student_status'), function ($query) use ($request) {
                return $query->where('student_status', $request->student_status);
            })
            ->when($request->filled('date_from'), function ($query) use ($request) {
                return $query->whereDate('created_at', '>=', $request->date_from);
            })
            ->when($request->filled('date_to'), function ($query) use ($request) {
                return $query->whereDate('created_at', '<=', $request->date_to);
            });

        // Fetch only pending requests
        $courseRequests = $query->where('status', 'pending')->get();

        // Add these lines to get the necessary data for dropdowns
        $courses = Course::all();
        $students = Student::all();
        $groups = Group::all();

        return view('admin.course_requests.index', compact(
            'courseRequests',
            'activeMajorPeriod',
            'courses',
            'students',
            'groups'
        ));
    }

    public function approve($id)
    {
        $courseRequest = CourseRequest::findOrFail($id);
        $courseRequest->status = 'approved'; // Update the status to approved
        $courseRequest->save(); // Save the changes to the database

        return response()->json(['success' => true]);
    }

    public function reject(Request $request, $id)
    {
        $courseRequest = CourseRequest::findOrFail($id);
        $courseRequest->status = 'rejected'; // Update the status to rejected
        $courseRequest->remarks = $request->remarks; // Save rejection remarks if needed
        $courseRequest->save(); // Save the changes to the database

        return response()->json(['success' => true]);
    }

    // Add new method to get counts
    public function getCounts()
    {
        try {
            $counts = [
                'pending' => CourseRequest::where('status', 'pending')->count(),
                'approved' => CourseRequest::where('status', 'approved')->count(),
                'rejected' => CourseRequest::where('status', 'rejected')->count()
            ];

            return response()->json($counts);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch counts: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Starting course request creation', [
            'student_id' => $request->student_id,
            'course_id' => $request->course,
            'group_id' => $request->group_id
        ]);

        // Check if major registration is open
        $activeRegistration = RegistrationPeriod::where('type', 'major')
        ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeRegistration) {
            return redirect()->back()->with('error', 'Major course registration is currently closed.');
        }

        // Check if student already has a request for this course
        $existingRequest = CourseRequest::where('student_id', $request->student_id)
            ->where('course_id', $request->course)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingRequest) {
            $status = ucfirst($existingRequest->status);
            return redirect()->back()
                ->with('error', "You already have a {$status} request for this course.")
                ->withInput();
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'course' => 'required|exists:courses,id',
            'group_id' => 'required|exists:groups,id',
            'matric_number' => 'required|string',
            'student_status' => 'required|in:scholarship,non-scholarship',
            'fee_receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'remarks' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Fetch the student's name and group details
        $student = \App\Models\Student::findOrFail($request->student_id);
        $group = Group::findOrFail($request->group_id);

        // Handle file upload
        $feeReceiptPath = null;
        if ($request->hasFile('fee_receipt')) {
            $feeReceiptPath = $request->file('fee_receipt')->store('fee_receipts', 'public');
        }

        // Add group validation
        if ($group->course_id != $request->course) {
            return Redirect::back()
                ->withErrors(['group' => 'Selected group does not belong to the selected course'])
                ->withInput();
        }

        // Check if group is full
        $currentEnrollments = $group->enrollments()->count();
        if ($currentEnrollments >= $group->max_students) {
            return Redirect::back()
                ->withErrors(['group' => 'Selected group is already full'])
                ->withInput();
        }

        // Create a new course request with group details
        $courseRequest = new CourseRequest([
            'student_id' => $request->student_id,
            'student_name' => $student->name,
            'course_id' => $request->course,
            'course_code' => $request->course_code,
            'program' => $student->program->name ?? 'Unknown Program',
            'matric_number' => $request->matric_number,
            'request_type' => $request->request_type,
            'student_status' => $request->student_status,
            'fee_receipt' => $feeReceiptPath,
            'status' => 'pending',
            'submission_date' => now(),
            'remarks' => $request->remarks,
            'registration_period_id' => $activeRegistration->id,
            // Add group details
            'group_id' => $group->id,
            'group_name' => $group->name,
            'day_of_week' => $group->day_of_week,
            'time' => $group->time,
            'place' => $group->place ?? 'TBA'
        ]);

        try {
            $courseRequest->save();
            Log::info('Course request created successfully', ['id' => $courseRequest->id]);
            return Redirect::back()->with('success', 'Course request submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to save course request:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Redirect::back()->withErrors(['error' => 'Failed to save course request.']);
        }
    }

    // Add method to check registration status
    public function checkRegistrationStatus()
    {
        $activeRegistration = RegistrationPeriod::where('type', 'major')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        return response()->json([
            'isOpen' => !is_null($activeRegistration),
            'registrationPeriod' => $activeRegistration ? [
                'start_date' => $activeRegistration->start_date->format('Y-m-d H:i:s'),
                'end_date' => $activeRegistration->end_date->format('Y-m-d H:i:s')
            ] : null
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        // Check registration period first
        $activeMajorPeriod = RegistrationPeriod::where('type', 'major')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        // Get student data
        $student = Auth::user()->student;
        $studentStatus = $student->scholarship_status === 'Scholarship';
        $matricNumber = $student->matric_number;

        // Only fetch and process courses if registration is open
        if ($activeMajorPeriod) {
            // Get all major courses
            $majorCourses = Course::where('type', 'major')->get();

            // Get student's existing course requests
            $existingRequests = CourseRequest::where('student_id', $student->id)
                ->whereIn('status', ['pending', 'approved'])
                ->with('course') // Eager load course relationship
                ->get();

            // Mark courses that student has already requested
            $majorCourses = $majorCourses->map(function ($course) use ($existingRequests) {
                $courseRequest = $existingRequests->where('course_id', $course->id)->first();

                $course->request_status = $courseRequest?->status;
                $course->is_registered = (bool)$courseRequest;
                $course->status_message = match ($courseRequest?->status) {
                    'pending' => '[Pending Approval]',
                    'approved' => '[Already Registered]',
                    default => ''
                };

                return $course;
            });
        } else {
            // If registration is closed, send empty collection
            $majorCourses = collect();
        }

        return view('student.major-course-registration', compact(
            'student',
            'studentStatus',
            'matricNumber',
            'majorCourses',
            'activeMajorPeriod'
        ));
    }

    public function showEnrollmentForm()
    {
        $students = Student::all();
        $groups = Group::with('course')->get();
        return view('admin.enrollments.create', compact('students', 'groups'));
    }

    public function getFormData()
    {
        try {
            $data = [
                'courses' => Course::all(),
                'students' => Student::all(),
                'groups' => Group::with('course')->get(),
                'days' => [
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Saturday'
                ]
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Error fetching form data: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to fetch form data'
            ], 500);
        }
    }
}
