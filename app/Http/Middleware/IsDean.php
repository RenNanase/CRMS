<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IsDean
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'faculty_dean') {
            return $next($request);
        }

        \Log::error('Dean access denied', [
            'user' => auth()->user(),
            'role' => auth()->user()->role ?? 'none'
        ]);

        return redirect('/')->with('error', 'Unauthorized access');
    }
}
