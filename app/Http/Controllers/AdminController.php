<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Event;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\News;


class AdminController extends Controller
{
    public function dashboard()
    {
        $students = Student::all();
        $totalStudents = $students->count();
        $lecturers = Lecturer::all();
        $totalLecturers = $lecturers->count();
        $events = Event::all(); // Fetch all events
        $totalCourses = Course::count();
        $latestNews = News::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('totalStudents', 'totalLecturers', 'events', 'totalCourses', 'latestNews')); // Pass events and total courses to the view
    }

    public function create()
    {
        $faculties = Faculty::all();
        // dd($faculties); // Remove or comment out this debug line
        return view('admin.students.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'matric_number' => 'required|string|max:255',
                'ic_number' => 'required|string|max:255',
                'current_semester' => 'required|integer',
                'phone' => 'required|string|max:15',
                'academic_year' => 'required|string|max:255',
                'address' => 'required|string',
                'scholarship_status' => 'required|string|max:255',
                'program_id' => 'required|exists:programs,id',
                'faculty_id' => 'required|exists:faculties,id',
            ]);

            $validatedData['password'] = bcrypt($validatedData['password']);

            // Create the user with role_id for student
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'role' => 'student',
                'role_id' => 2  // Assuming 3 is the role_id for students in your roles table
            ]);

            // Create the student record
            Student::create([
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'matric_number' => $validatedData['matric_number'],
                'ic_number' => $validatedData['ic_number'],
                'current_semester' => $validatedData['current_semester'],
                'phone' => $validatedData['phone'],
                'academic_year' => $validatedData['academic_year'],
                'scholarship_status' => $validatedData['scholarship_status'],
                'faculty_id' => $validatedData['faculty_id'],
                'program_id' => $validatedData['program_id'],
                'address' => $validatedData['address'],
            ]);

            return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating student: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create student. ' . $e->getMessage());
        }
    }

    public function index()
    {
        $students = Student::all();
        return view('admin.students.index', compact('students'));
    }
}
