<?php

namespace App\Http\Controllers;

use App\Models\Lecturer; // Ensure you have a Lecturer model
use App\Models\Faculty;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use App\Models\CourseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LecturerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Only apply lecturer middleware to specific methods
        $this->middleware('isLecturer')->only([
            'dashboard',
            'myCourses',
            'courseStudents'
            // Add other lecturer-specific methods here
        ]);
    }

    public function index()
    {
        try {
            if (strtolower(auth()->user()->role) !== 'admin') {
                Log::warning('Unauthorized access attempt to lecturer index', [
                    'user' => auth()->user()
                ]);
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            $lecturers = Lecturer::with(['faculty', 'courses'])->get();
            return view('admin.lecturers.index', compact('lecturers'));
        } catch (\Exception $e) {
            Log::error('Error in lecturer index', [
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->with('error', 'An error occurred while loading the lecturer list.');
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:15',
                'faculty_id' => 'required|exists:faculties,id',
                'course_ids' => 'required|array',
                'course_ids.*' => 'exists:courses,id',
                'lecturer_id' => 'required|string|unique:lecturers,lecturer_id',
                'password' => 'required|string|min:8|confirmed',
            ]);

            // Begin transaction
            \DB::beginTransaction();

            // 1. Create user account first
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'lecturer',
                'role_id' => 3  // Assuming 3 is for lecturer role
            ]);

            // 2. Create lecturer profile
            $lecturer = Lecturer::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'faculty_id' => $request->faculty_id,
                'lecturer_id' => $request->lecturer_id,
            ]);

            // 3. Attach selected courses to the lecturer
            if ($request->has('course_ids')) {
                $lecturer->courses()->attach($request->course_ids);
            }

            // If everything is successful, commit the transaction
            \DB::commit();

            // Redirect with success message
            return redirect()->route('admin.lecturers.index')
            ->with('success', 'Lecturer account created successfully.');
        } catch (\Exception $e) {
            // If anything fails, rollback the transaction
            \DB::rollBack();

            \Log::error('Error creating lecturer: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create lecturer account. ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:lecturers,email,' . $id,
            'phone' => 'required|string|max:15',
            'faculty_id' => 'required|exists:faculties,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id'
        ]);

        $lecturer = Lecturer::findOrFail($id);

        $lecturer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'faculty_id' => $request->faculty_id,
        ]);

        // Sync courses (this will remove unselected courses and add new ones)
        $lecturer->courses()->sync($request->course_ids);

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer updated successfully.');
    }

    public function destroy($id)
    {
        $lecturer = Lecturer::findOrFail($id);

        // Detach all courses first
        $lecturer->courses()->detach();

        // Delete the lecturer
        $lecturer->delete();

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer deleted successfully.');
    }

    public function create()
    {
        if (strtolower(auth()->user()->role) !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
//Retrieves all records from the faculties table
        $faculties = Faculty::all();
//Retrieves all records from the courses table
        $courses = Course::all();
        return view('admin.lecturers.create', compact('faculties', 'courses')); //compact-pass data to the view
    }



    public function edit($id)
    {
        $lecturer = Lecturer::with(['faculty', 'courses'])->findOrFail($id);
        $faculties = Faculty::all();
        $courses = Course::all();
        return view('admin.lecturers.edit', compact('lecturer', 'faculties', 'courses'));
    }

    public function getLecturersByCourse(Request $request)
{
    $courseId = $request->query('course_id');
    $lecturers = Lecturer::where('course_id', $courseId)->get();
    return response()->json($lecturers);
}

//lecturer-access dashboard

public function dashboard()
{
    Log::info('Accessing lecturer dashboard', [
        'user' => auth()->user(),
        'time' => now()
    ]);

    $lecturer = auth()->user()->lecturer;

    if (!$lecturer) {
        Log::error('No lecturer profile found for user', [
            'user_id' => auth()->id()
        ]);
        return redirect()->route('home')->with('error', 'Lecturer profile not found.');
    }

    // Use the many-to-many relationship
    $totalCourses = $lecturer->courses()->count();

    $totalStudents = $lecturer->courses()
        ->withCount('students')
        ->get()
        ->sum('students_count');

    $events = Event::orderBy('start_date', 'asc')->get();
    $latestNews = News::with('user')
        ->latest()
        ->take(5)
        ->get();

    return view('lecturer.dashboard', compact('events', 'latestNews', 'totalCourses', 'totalStudents'));
}

public function myCourses()
{
    try {
        $lecturer = auth()->user()->lecturer;

        if (!$lecturer) {
            Log::error('No lecturer profile found for user', [
                'user_id' => auth()->id()
            ]);
            return redirect()->route('home')->with('error', 'Lecturer profile not found.');
        }

        // Use the many-to-many relationship
        $courses = $lecturer->courses()
            ->with(['students', 'faculty'])
            ->get();

        Log::info('Lecturer courses fetched', [
            'lecturer_id' => $lecturer->id,
            'courses_count' => $courses->count()
        ]);

        return view('lecturer.courses.index', compact('courses'));
    } catch (\Exception $e) {
        Log::error('Error fetching lecturer courses', [
            'error' => $e->getMessage()
        ]);
        return back()->with('error', 'Unable to fetch courses. Please try again.');
    }
}

    public function courseStudents($course_id)
    {
        try {
            $lecturer = auth()->user()->lecturer;

            // Get course with approved students from course_requests
            $course = Course::whereHas('lecturers', function ($query) use ($lecturer) {
                $query->where('lecturers.id', $lecturer->id);
            })->findOrFail($course_id);

            // Get approved students from course_requests with all necessary relationships
            $enrolledStudents = CourseRequest::where('course_id', $course_id)
                ->where('status', 'approved')
                ->with(['student.program', 'student.faculty'])
                ->get()
                ->map(function ($request) {
                    return [
                        'student' => $request->student,
                        'matric_number' => $request->matric_number,
                        'group_name' => $request->group_name,
                        'day_of_week' => $request->day_of_week,
                        'time' => $request->time,
                        'place' => $request->place,
                        'request_type' => $request->request_type,
                        'status' => $request->status,
                        'submission_date' => $request->submission_date
                    ];
                });

            Log::info('Course students fetched', [
                'course_id' => $course_id,
                'student_count' => $enrolledStudents->count()
            ]);

            return view('lecturer.students.index', compact('course', 'enrolledStudents'));
        } catch (\Exception $e) {
            Log::error('Error fetching course students', [
                'course_id' => $course_id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Unable to fetch students. Please try again.');
        }
    }

    public function profile()
    {
        $lecturer = auth()->user()->lecturer;
        return view('lecturer.profile', compact('lecturer'));
    }

    public function editProfile($id)
    {
        $lecturer = Lecturer::findOrFail($id);
        $faculties = Faculty::all();
        $courses = Course::all();
        // Check if the authenticated user is the owner of this profile
        if (auth()->user()->lecturer->id !== $lecturer->id) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        return view('lecturer.profile.edit', compact('lecturer', 'faculties', 'courses'));
    }

    public function updateProfile(Request $request, $id)
    {
        $lecturer = Lecturer::findOrFail($id);

        // Check if the authenticated user is the owner of this profile
        if (auth()->user()->lecturer->id !== $lecturer->id) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $lecturer->user_id,
            'phone' => 'required|string|max:15',
            'faculty_id' => 'required|exists:faculties,id',
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            // Update user information
            $user = $lecturer->user;
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            // Handle photo upload
            if ($request->hasFile('photo')) {
                if ($lecturer->photo) {
                    Storage::disk('public')->delete($lecturer->photo);
                }
                $photo = $request->file('photo');
                $photoPath = $photo->store('lecturer_photos', 'public');
                $lecturer->photo = $photoPath;
            }

            // Update lecturer information
            $lecturer->name = $request->name;
            $lecturer->email = $request->email;
            $lecturer->phone = $request->phone;
            $lecturer->faculty_id = $request->faculty_id;
            $lecturer->save();

            // Update courses
            $lecturer->courses()->sync($request->course_ids);

            DB::commit();

            return redirect()->route('lecturer.profile')
            ->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

}
