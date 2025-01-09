<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPeriod;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistrationPeriodController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        // Get academic periods for the filter
        $academicPeriods = AcademicPeriod::select('academic_year')
            ->distinct()
            ->orderBy('academic_year')
            ->get();

        $registrationPeriods = RegistrationPeriod::with('academicPeriod')
            ->when(request('academic_year'), function($query) {
                return $query->whereHas('academicPeriod', function($q) {
                    $q->where('academic_year', request('academic_year'));
                });
            })
            ->when(request('type'), function($query) {
                return $query->where('type', request('type'));
            })
            ->orderBy('start_date')
            ->paginate(10)
            ->through(function ($period) use ($now) {
                $period->status = $this->calculateStatus($period, $now);
                return $period;
            });

        return view('admin.registration-periods.index', compact('registrationPeriods', 'academicPeriods'));
    }

    private function calculateStatus($period, $now)
    {
        $now = Carbon::now()->setTimezone('Asia/Brunei');
        $startDate = Carbon::parse($period->start_date)->setTimezone('Asia/Brunei');
        $endDate = Carbon::parse($period->end_date)->setTimezone('Asia/Brunei');

        if ($now->timestamp > $endDate->timestamp) {
            return 'closed';
        } elseif ($now->timestamp < $startDate->timestamp) {
            return 'upcoming';
        } else {
            return 'active';
        }
    }

    public function create()
    {
        $academicPeriods = AcademicPeriod::orderBy('start_date')->get();
        return view('admin.registration-periods.create', compact('academicPeriods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'type' => 'required|in:major,minor',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Convert dates to Carbon instances for proper storage
        $validated['start_date'] = Carbon::parse($validated['start_date']);
        $validated['end_date'] = Carbon::parse($validated['end_date']);

        RegistrationPeriod::create($validated);

        return redirect()->route('admin.registration-periods.index')
            ->with('success', 'Registration period created successfully');
    }

    public function update(Request $request, RegistrationPeriod $registrationPeriod)
    {
        $validated = $request->validate([
            'academic_period_id' => 'sometimes|required|exists:academic_periods,id',
            'type' => 'sometimes|required|in:major,minor',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
        ]);

        if (isset($validated['start_date'])) {
            $validated['start_date'] = Carbon::parse($validated['start_date']);
        }
        if (isset($validated['end_date'])) {
            $validated['end_date'] = Carbon::parse($validated['end_date']);
        }

        $registrationPeriod->update($validated);

        return redirect()->route('admin.registration-periods.index')
            ->with('success', 'Registration period updated successfully');
    }

    public function getStatusAttribute()
    {
        $now = now();

        if ($now >= $this->attributes['start_date'] && $now <= $this->attributes['end_date']) {
            return 'active';
        } elseif ($now < $this->attributes['start_date']) {
            return 'upcoming';
        } else {
            return 'closed';
        }
    }

    public function edit(RegistrationPeriod $registrationPeriod)
    {
        $academicPeriods = AcademicPeriod::orderBy('start_date')->get();
        return view('admin.registration-periods.edit', compact('registrationPeriod', 'academicPeriods'));
    }

    public function destroy(RegistrationPeriod $registrationPeriod)
    {
        $registrationPeriod->delete();

        return redirect()->route('admin.registration-periods.index')
        ->with('success', 'Registration period deleted successfully');
    }
}
