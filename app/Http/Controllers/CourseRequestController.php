<?php
namespace App\Http\Controllers;

use App\Models\CourseRequest;
use App\Models\Student;
use App\Models\Group;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\MajorCourseRegistration;
use Illuminate\Support\Facades\Auth;
use App\Models\RegistrationPeriod;


class CourseRequestController extends Controller
{
        public function index(Request $request)
        {
            $query = CourseRequest::with(['group', 'course'])
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


            return view('admin.course_requests.index', compact('courseRequests'));
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
        // Add this at the beginning of your store method
        $activeRegistration = RegistrationPeriod::where('status', 'active')
        ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeRegistration) {
            return redirect()->back()->with('error', 'Course registration is currently closed.');
        }

        \Log::info('Store method called', $request->all());
        \Log::info('Incoming request data:', $request->all());

        // Log method entry
        \Log::info('Entering store method.');

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|exists:students,id',
            'course' => 'required|exists:courses,id',
            'matric_number' => 'required|string',
            'student_status' => 'required|in:scholarship,non-scholarship',
            'fee_receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validate file type and size
            'remarks' => 'nullable|string|max:255',
        ]);

        // Log validation results
        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }
        \Log::info('Validation passed:', $validator->validated());

        // Fetch the student's name
        $student = \App\Models\Student::findOrFail($request->student_id);

        // Handle file upload
        $feeReceiptPath = null;
        if ($request->hasFile('fee_receipt')) {
            $feeReceiptPath = $request->file('fee_receipt')->store('fee_receipts', 'public');
        }

        // Fetch the group_id based on the course_id or any other criteria
        $group = Group::where('course_id', $request->course)->first();

        if (!$group) {
            // Handle the case where no group is found
            return response()->json(['error' => 'Group not found'], 404);
        }

        // Create a new course request
        $courseRequest = new CourseRequest([
            'student_id' => $request->student_id,
            'student_name' => $student->name,
            'course_id' => $request->course,
            'course_code' => $request->course_code,
            'program' => $student->program->name ?? 'Unknown Program', // Automatically use student's program
            'matric_number' => $request->matric_number,
            'request_type' => 'major', // Set request type to major only
            'student_status' => $request->student_status,
            'fee_receipt' => $feeReceiptPath, // Save the path
            'status' => 'pending',
            'group_id' => $group->id, // Set the group_id from the fetched group
            'submission_date' => now(),
            'remarks' => $request->remarks,
        ]);

        // Set submission date automatically
        $courseRequest->submission_date = now();

        // Log the data before saving
        \Log::info('Data ready to be saved:', $courseRequest->toArray());

        // Log the CourseRequest object
        \Log::info('CourseRequest object:', $courseRequest->toArray());

        // Log before saving
        \Log::info('About to save CourseRequest object.');

        try {
            $courseRequest->save();
            return Redirect::back()->with('success', 'Course request submitted successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to save course request:', ['error' => $e->getMessage()]);
            return Redirect::back()->withErrors(['error' => 'Failed to save course request.']);
        }
    }
    public function showRegistrationForm(Request $request)
    {
        if (!Auth::user()) {
            \Log::info('User is not authenticated.');
            return redirect()->route('login');
        }

        \Log::info('User ID:', ['id' => Auth::id()]);
        $registrations = MajorCourseRegistration::where('student_id', Auth::id())->get();
        \Log::info('Registrations:', $registrations->toArray());

        return view('student.major-course-registration', compact('registrations'));
    }
    public function registerCourse(Request $request)
    {
        \Log::info('Register Course Method Called', ['request' => $request->all()]);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $registration = new MajorCourseRegistration();
        $registration->student_id = $request->user()->id;
        $registration->course_id = $request->course_id;
        $registration->status = 'pending';
        $registration->save();

        \Log::info('Registration Saved', ['registration' => $registration]);

        return redirect()->route('student.registerMajorCourses')->with('success', 'Course registered successfully!');
    }

    public function getGroupInfo(Course $course): JsonResponse
    {
        try {
            // Assuming you have a relationship between Course and Group models
            $group = $course->group;  // This assumes you have a group() relationship defined

            if (!$group) {
                return response()->json([
                    'error' => 'No group found for this course'
                ], 404);
            }

            return response()->json([
                'group_id' => $group->id,
                'group_name' => $group->name ?? 'Group ' . $group->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error fetching group information'
            ], 500);
        }
    }



}
