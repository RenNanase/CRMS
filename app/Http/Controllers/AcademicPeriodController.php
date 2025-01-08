<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AcademicPeriod;
use Illuminate\Http\Request;

class AcademicPeriodController extends Controller
{
    public function index()
    {
        $academicPeriods = AcademicPeriod::latest()->paginate(10);
        return view('admin.academic-periods.index', compact('academicPeriods'));
    }

    public function create()
    {
        return view('admin.academic-periods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'academic_year' => 'required|string',
            'semester' => 'required|in:1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive'
        ]);

        AcademicPeriod::create($validated);

        return redirect()->route('admin.academic-periods.index')
            ->with('success', 'Academic period created successfully');
    }
}
