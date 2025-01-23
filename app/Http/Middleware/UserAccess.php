<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserAccess
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(strtolower(auth()->user()->role) !== strtolower($role)) {
            Log::warning('Access denied in UserAccess middleware', [
                'user_role' => auth()->user()->role,
                'required_role' => $role
            ]);
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        return $next($request);
    }
}
