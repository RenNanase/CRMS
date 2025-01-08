<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RegistrationPeriod;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class RegistrationPeriodController extends Controller
{
    public function index()
    {
        $registrationPeriods = RegistrationPeriod::with('academicPeriod')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('admin.registration-periods.index', compact('registrationPeriods'));
    }

    public function create()
    {
        $academicPeriods = AcademicPeriod::orderBy('start_date', 'desc')->get();
        return view('admin.registration-periods.create', compact('academicPeriods'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_period_id' => 'required|exists:academic_periods,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        RegistrationPeriod::create($validated);

        return redirect()->route('admin.registration-periods.index')
            ->with('success', 'Registration period created successfully');
    }

    public function update(Request $request, RegistrationPeriod $registrationPeriod)
    {
        $validated = $request->validate([
            'status' => 'required|in:upcoming,active,closed',
        ]);

        $registrationPeriod->update($validated);

        return redirect()->route('admin.registration-periods.index')
            ->with('success', 'Registration period updated successfully');
    }
}
