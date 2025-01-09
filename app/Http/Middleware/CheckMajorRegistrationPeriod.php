<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RegistrationPeriod;
use Illuminate\Http\Request;

class CheckMajorRegistrationPeriod
{
    public function handle(Request $request, Closure $next)
    {
        $activeMajorPeriod = RegistrationPeriod::where('type', 'major')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeMajorPeriod) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Major course registration is currently closed.'], 403);
            }

            // Redirect to dashboard with error message
            return redirect()->route('student.dashboard')
                ->with('error', 'Major course registration is currently closed.');
        }

        return $next($request);
    }
}
