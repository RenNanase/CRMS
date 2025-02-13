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
        try {
            // Validate the login request
            $infologin = $request->only('email', 'password');

            // Enhanced logging before attempt
            $user = \App\Models\User::where('email', $request->email)->first();

            Log::info('Login attempt details', [
                'email' => $request->email,
                'password_provided' => !empty($request->password),
                'user_exists' => !is_null($user),
                'user_details' => $user ? [
                    'id' => $user->id,
                    'role' => $user->role,
                    'password_hash_exists' => !empty($user->password),
                ] : null
            ]);

            if (Auth::attempt($infologin)) {
                $user = Auth::user();

                Log::info('Login successful', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'role' => $user->role
                ]);

                // Handle role-based redirections
                switch (strtolower($user->role)) {  // Convert to lowercase for case-insensitive comparison
                    case 'lecturer':
                        Log::info('Redirecting to lecturer dashboard');
                        return redirect()->route('lecturer.dashboard');
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'faculty_dean':
                    case 'dean':  // Add alternative case
                        Log::info('Redirecting to dean dashboard', ['role' => $user->role]);
                        return redirect()->route('dean.dashboard');
                    case 'student':
                        return redirect()->route('student.dashboard');
                    default:
                        Log::warning('No specific route for role', ['role' => $user->role]);
                        return redirect('/');
                }
            }

            // If login fails, log detailed information
            Log::error('Login failed', [
                'email' => $request->email,
                'user_exists' => !is_null($user),
                'password_verification' => $user ? \Hash::check($request->password, $user->password) : false,
                'role' => $user ? $user->role : null
            ]);

            return redirect('/')->with('error', 'Login details are not valid');
        } catch (\Exception $e) {
            Log::error('Login exception occurred', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect('/')->with('error', 'An error occurred during login');
        }
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
