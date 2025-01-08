<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UserAccess
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');  // Remove the with() message to avoid session issues
        }

        // Get user's role and convert both to lowercase for comparison
        $userRole = strtolower(Auth::user()->role);
        $requiredRole = strtolower($role);

        // Check if user has the required role
        if ($userRole !== $requiredRole) {
            return redirect('/');  // Change to redirect to home instead of back()
        }

        return $next($request);
    }
}
