<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MinorRegistration;
use Illuminate\Auth\Access\HandlesAuthorization;

class MinorRegistrationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        // Convert role to lowercase for consistent comparison
        $role = strtolower($user->role);
        
        // Allow these roles to view registrations
        $allowedRoles = ['student', 'program_head', 'admin'];
        
        return in_array($role, $allowedRoles);
    }

    public function view(User $user, MinorRegistration $minorRegistration): bool
    {
        $role = strtolower($user->role);
        
        // Admin can view all
        if ($role === 'admin') {
            return true;
        }
        
        // Program head can view all
        if ($role === 'program_head') {
            return true;
        }
        
        // Students can only view their own
        if ($role === 'student') {
            // Get the student record associated with the user
            $student = Student::where('user_id', $user->id)->first();
            return $student && $minorRegistration->student_id === $student->id;
        }
        
        return false;
    }
}