<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    public function index()
    {
        return view('frontend/login');
    }

    public function login(Request $request)
    {
        // Validate the login request
        $infologin = $request->only('email', 'password');

        if (Auth::attempt($infologin)) {
            $user = Auth::user();

            // Log the user's role for debugging
            Log::info('User login attempt:', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role
            ]);

            // Fetch the logged-in student's scholarship status if user is a student
            if ($user->role === 'student') {
                $student = Student::where('user_id', $user->id)->first();
                if ($student) {
                    session(['is_scholarship' => $student->scholarship_status]);
                }
            }

            // Simplified role check and redirect
            switch (strtolower($user->role)) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'faculty_dean':
                    return redirect()->route('dean.dashboard');
                case 'student':
                    return redirect()->route('student.dashboard');
                default:
                    Auth::logout();
                    return redirect('/')->with('error', 'Invalid user role');
            }
        }

        return redirect('/')->with('error', 'Invalid credentials');
    }





    public function logout()
    {
        Auth::logout();
        session()->flush(); // Clear all session data
        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'matric_number' => 'required|string',
            'programme' => 'required|string',
            'batch' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        $student = Student::findOrFail($id);
        $student->update($validatedData);

        return redirect()->route('students.profile', ['id' => $student->id])->with('success', 'Profile updated successfully.');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'student') {
            return redirect()->route('student.dashboard');
        }
        // ... handle other roles
    }
}
