<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RegistrationPeriod;

class CheckRegistrationPeriod
{
    public function handle($request, Closure $next, $type)
    {
        \Log::info('CheckRegistrationPeriod middleware running', [
            'type' => $type,
            'user_id' => auth()->id(),
            'url' => $request->url()
        ]);

        $activePeriod = RegistrationPeriod::where('type', $type)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        \Log::info('Active period check:', [
            'active_period' => $activePeriod,
            'current_time' => now()
        ]);

        if (!$activePeriod) {
            \Log::warning('No active registration period found for type: ' . $type);
            return redirect()->route('student.dashboard')
                ->with('error', ucfirst($type) . ' course registration is currently closed.');
        }

        return $next($request);
    }
}
