<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\Course;

class TimetableController extends Controller
{
    public function show(Timetable $timetable)
    {
        // ... existing code ...

        $courses = Course::orderBy('code')->get();

        return view('admin.timetables.show', compact('timetable', 'courses'));
    }
}
