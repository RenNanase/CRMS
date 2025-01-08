<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Faculty; // Added the Faculty model
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    // Display a listing of the courses.
    public function index(Request $request)
    {
        $query = Course::query();

        // Apply filters
        if ($request->filled('search')) {
            $query->where('course_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('faculty')) {
            $query->where('faculty_id', $request->faculty);
        }

        if ($request->filled('course_code')) {
            $query->where('course_code', 'like', '%' . $request->course_code . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Get faculties for the dropdown
        $faculties = Faculty::all();

        // Get paginated results
        $courses = $query->paginate(10);

        return view('admin.courses.index', compact('courses', 'faculties'));
    }

// Method to display the course creation form
    public function create()
{
    $faculties = Faculty::all(); // Retrieve all faculties
    $courses = Course::paginate(10); // Retrieve all courses for prerequisites
    return view('admin.courses.create', compact('faculties', 'courses')); // Pass faculties and courses to the create view
    }

        // Method to handle course creation
    public function createCourse(Request $request)
{
        // Validate the incoming request
        $validatedData = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:10',
            'credit_hours' => 'required|integer',
            'capacity' => 'nullable|integer',
            'faculty_id' => 'required|exists:faculties,id',
            'type' => 'required|in:major,minor',
            'prerequisite_ids' => 'nullable|array',
        ]);

        // Create or update the course
        $course = Course::updateOrCreate([
            'id' => $request->input('id'), // Assuming you pass the course ID for updates
        ], $validatedData);

        // Handle prerequisites if provided
        if ($request->filled('prerequisite_ids')) {
            $course->prerequisites()->sync($request->input('prerequisite_ids')); // Sync the prerequisites
        }

        // Clear existing groups for the course
        Group::where('course_id', $course->id)->delete();

        // Determine number of groups based on capacity
        $capacity = $validatedData['capacity'];

        // Debugging log for capacity
        \Log::info('Capacity entered:', ['capacity' => $capacity]);

        $numGroups = 1;
        if ($capacity > 30) {
            $numGroups = ceil($capacity / 30);
        }

        // Debugging log for number of groups
        \Log::info('Number of groups to create:', ['numGroups' => $numGroups]);

        // Create groups based on the calculated number
        $groupNames = range('A', 'Z'); // Use A to Z for group names
        for ($i = 0; $i < $numGroups; $i++) {
            if ($i < count($groupNames)) {
                Group::create([
                    'group_name' => $groupNames[$i],
                    'course_id' => $course->id,
                    'capacity' => 30,
                    'current_enrollment' => 0,
                ]);
            }
        }

        return redirect()->route('courses.index')->with('success', 'Course and groups created/updated successfully.');
    }

    // Store a newly created course in storage.
    public function store(Request $request)
    {
        \Log::info('Course creation request data:', $request->all());
        // Validate the incoming request
        $validatedData = $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:10',
            'credit_hours' => 'required|integer',
            'capacity' => 'nullable|integer',
            'faculty_id' => 'required|exists:faculties,id',
            'type' => 'required|in:major,minor',
            'prerequisite_ids' => 'nullable|array',
        ]);

        try {
            // Create the course with explicit faculty_id
            $course = Course::create([
                'course_name' => $validatedData['course_name'],
                'course_code' => $validatedData['course_code'],
                'credit_hours' => $validatedData['credit_hours'],
                'capacity' => $validatedData['capacity'],
                'faculty_id' => $validatedData['faculty_id'],  // Explicitly include faculty_id
                'type' => $validatedData['type']
            ]);

            // Handle prerequisites if provided
            if ($request->filled('prerequisite_ids')) {
                $course->prerequisites()->sync($request->input('prerequisite_ids'));
            }

            // Create groups based on capacity
            if ($validatedData['capacity']) {
                $numGroups = ceil($validatedData['capacity'] / 30);
                $groupNames = range('A', 'Z');

                for ($i = 0; $i < $numGroups && $i < count($groupNames); $i++) {
                    Group::create([
                        'group_name' => $groupNames[$i],
                        'course_id' => $course->id,
                        'capacity' => 30,
                        'current_enrollment' => 0,
                    ]);
                }
            }

            return redirect()->route('courses.index')->with('success', 'Course and groups created successfully!');
        } catch (\Exception $e) {
            \Log::error('Course creation error: ' . $e->getMessage());
            return back()->with('error', 'Error creating course: ' . $e->getMessage())->withInput();
        }
    }


    // Show the form for editing the specified course.
    public function edit(Course $course)
    {
        $faculties = Faculty::all(); // Retrieve all faculties
        $courses = Course::paginate(10); // Retrieve all courses for prerequisites if needed
        return view('admin.courses.edit', compact('course', 'faculties', 'courses')); // Pass course, faculties, and courses to the edit view
    }

    // Update the specified course in storage.
    public function update(Request $request, Course $course)
    {
        \Log::info('Request Method: ' . $request->method());

        $validatedData = $request->validate([
        'course_name' => 'required|string|max:255',
        'course_code' => 'nullable|string|max:10',
        'credit_hours' => 'nullable|integer',
        'capacity' => 'nullable|integer',
        'faculty_id' => 'required|exists:faculties,id',
        'type' => 'required|in:major,minor',
        'prerequisite_ids' => 'nullable|array', // Accept an array of prerequisite IDs, but it's optional
    ]);

    // Ensure faculty_id is included in the validated data
    $validatedData['faculty_id'] = $validatedData['faculty_id'];

    // Update the course with the validated data
    $course->update($validatedData);

    // Update the prerequisites
    if ($request->has('prerequisite_ids')) {
        // Sync the prerequisites, this will attach new ones and detach those not included
        $course->prerequisites()->sync($request->input('prerequisite_ids'));
    }

    return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    // Remove the specified course from storage.
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function faculty()
{
    return $this->belongsTo(Faculty::class);
}

//Student enrollment

    public function submitMajorCourses(Request $request) {
        // Validate and process the enrollment data
        $data = $request->validate([
            'course_ids' => 'required|array',
        ]);

        return redirect()->back()->with('success', 'Enrollment successful!');
    }

    public function submitMinorCourses(Request $request) {
        // Validate and process the enrollment data
        $data = $request->validate([
            'course_ids' => 'required|array',
        ]);
        return redirect()->back()->with('success', 'Enrollment successful!');
    }

    public function showMajorCourseRegistration($student_id)
    {
        Log::info('Method called with student_id: ' . $student_id);


        $student = Student::find($student_id);
        Log::info('Student retrieved:', ['student' => $student]);

        if (!$student) {
            Log::error('Student not found for student_id: ' . $student_id);
            return redirect()->back()->with('error', 'Student not found');
        }


        $courses = Course::paginate(10); // Fetch all courses
        $groups = Group::all(); // Fetch all groups directly
        $majorCourses = Course::where('type', 'major')->paginate(10); // Fetch all major courses
        Log::info('Preparing to return view with student:', ['student' => $student]);
        Log::info('Major courses retrieved:', ['courses' => $majorCourses]);

        return view('student.major-course-registration', compact('student', 'courses', 'groups', 'majorCourses'));
    }

    public function showMinorCourseRegistration($student_id)
    {
        $student = Student::find($student_id);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found');
        }
        $courses = Course::paginate(10); // Fetch all courses
        $groups = Group::allGroups(); // Get the fixed groups
        return view('student.minor-course-registration', compact('student', 'courses', 'groups'));
    }

    public function enrollStudent(Request $request, $groupId)
{
    $group = Group::find($groupId);

    // Check if there's capacity
    if ($group->current_enrollment < $group->capacity) {
        // Enroll the student (you might want to create a pivot table for enrollments)
        // Example: Student::find($studentId)->groups()->attach($groupId);

        // Increment the current enrollment
        $group->current_enrollment++;
        $group->save();

        return redirect()->back()->with('success', 'Student enrolled successfully.');
    } else {
        return redirect()->back()->with('error', 'Group is full.');
    }
}

    public function getGroupsByCourse($courseId)
    {
        $groups = Group::where('course_id', $courseId)->get();
        return response()->json(['groups' => $groups]);
    }

    public function showPrerequisites($id)
    {
        $course = Course::with('prerequisites')->find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $prerequisites = $course->prerequisites;

        return response()->json([
            'prerequisites' => $prerequisites
        ]);
    }

    public function registerCourse(Request $request)
    {
        $validatedData = $request->validate([
            'fee_receipt' => 'required_if:is_scholarship,no|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validate fee receipt
        ]);

        // Handle the registration logic...
    }
    public function getGroupInfo($courseId)
{
    $groups = Group::where('course_id', $courseId)->get();

    if ($groups->isEmpty()) {
        return response()->json(['error' => 'No groups found for this course'], 404);
    }

    return response()->json([
        'group_id' => $groups->first()->id, // Assuming you want the first group
        'group_name' => $groups->first()->group_name,
    ]);
}
}
