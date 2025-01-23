<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                switch ($user->role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'student':
                        return redirect()->route('student.dashboard');
                    case 'faculty_dean':
                        return redirect()->route('dean.dashboard');
                    case 'lecturer':
                        return redirect()->route('lecturer.dashboard');
                    default:
                        return redirect('/home');
                }
            }
        }

        return $next($request);
    }
}
