<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RegistrationPeriod;

class CheckRegistrationPeriod
{
    public function handle($request, Closure $next)
    {
        $activeRegistration = RegistrationPeriod::where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$activeRegistration) {
            return redirect()->route('dashboard')
                ->with('error', 'Course registration is currently closed.');
        }

        // Add the active registration period to the request
        $request->merge(['active_registration' => $activeRegistration]);

        return $next($request);
    }
}
