<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dean;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Faculty;
class DeanProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        // Create dean record if it doesn't exist
        $dean = Dean::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => '',
                'office_location' => '',
                'faculty' => $user->faculty_id ? Faculty::find($user->faculty_id)->faculty_name : '',
                'staff_id' => '',
                'position' => 'dean'
            ]
        );

        \Log::info('Dean Profile Data:', [
            'user_id' => $user->id,
            'dean_data' => $dean,
            'faculty_id' => $user->faculty_id ?? 'No faculty ID'
        ]);

        return view('dean.profile.show', compact('user', 'dean'));
    }

    public function edit()
    {
        $user = Auth::user();
        $dean = Dean::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => '',
                'office_location' => '',
                'faculty' => $user->faculty_id ? Faculty::find($user->faculty_id)->faculty_name : '',
                'staff_id' => '',
                'position' => 'dean'
            ]
        );

        return view('dean.profile.edit', compact('user', 'dean'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        //ensure dean record exists for the user if not create one
        $dean = Dean::firstOrCreate(['user_id' => $user->id]);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'office_location' => 'required|string|max:255',
            'staff_id' => 'required|string|max:50|unique:deans,staff_id,' . $dean->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        try {
            // Update user information
            $user->name = $request->name;
            $user->email = $request->email;

            // Handle password change if provided
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()->withErrors(['current_password' => 'The current password is incorrect.']);
                }
                $user->password = Hash::make($request->new_password);
            }

            // Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                if ($dean->profile_picture) {
                    Storage::disk('public')->delete($dean->profile_picture);
                }
                $path = $request->file('profile_picture')->store('profile_photos', 'public');
                $dean->profile_picture = $path;
            }

            // Update dean information
            $dean->phone = $request->phone;
            $dean->office_location = $request->office_location;
            $dean->staff_id = $request->staff_id;
            $dean->faculty = $user->faculty_id ? Faculty::find($user->faculty_id)->faculty_name : '';

            // Save changes
            $user->save();
            $dean->save();

            \Log::info('Dean profile updated successfully', [
                'user_id' => $user->id,
                'dean_id' => $dean->id
            ]);

            return redirect()->route('dean.profile.show')
                ->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Error updating dean profile:', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return back()->with('error', 'An error occurred while updating your profile.')
                ->withInput();
        }
    }
}
