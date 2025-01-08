<?php

namespace App\Http\Controllers;

use App\Models\Lecturer; // Ensure you have a Lecturer model
use App\Models\Faculty;
use App\Models\Course;
use Illuminate\Http\Request;

class LecturerController extends Controller
{
    public function index()
    {
        $lecturers = Lecturer::with(['faculty', 'courses'])->get();
        return view('admin.lecturers.index', compact('lecturers'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:lecturers',
            'phone' => 'required|string|max:15',
            'faculty_id' => 'required|exists:faculties,id',
            'course_ids' => 'required|array', // Changed from 'courses'
            'course_ids.*' => 'exists:courses,id', // Changed from 'courses.*'
            'lecturer_id' => 'required|unique:lecturers,lecturer_id',
        ]);

        // Create lecturer with all fields
        $lecturer = Lecturer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'faculty_id' => $request->faculty_id,
            'lecturer_id' => $request->lecturer_id,
        ]);

        // Attach courses
        $lecturer->courses()->attach($request->course_ids); // Changed from 'courses'

        return redirect()->route('lecturers.index')
            ->with('success', 'Lecturer created successfully.');
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
        return $this->createLecturer(); // Call createLecturer to get faculties
    }

    public function createLecturer()
    {
        $faculties = Faculty::all();
        $courses = Course::all();
        return view('admin.lecturers.create', compact('faculties', 'courses')); // Pass both faculties and courses to the view
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

}
