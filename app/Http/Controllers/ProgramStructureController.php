<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\ProgramStructure;
use App\Models\Faculty; // Add this import
use Illuminate\Support\Facades\Storage;
use App\Models\Program;
class ProgramStructureController extends Controller
{

    public function index()
    {
        // Get program structures, faculties, and programs
        $programStructures = ProgramStructure::with('faculty')
            ->orderBy('program_name')
            ->get();
        $faculties = Faculty::all();
        $programs = Program::all(); // Add this line

        return view(
            'admin.program-structures.index',
            compact('programStructures', 'faculties', 'programs')
        ); // Add programs to compact
    }


    public function edit($id)
    {
        $programStructure = ProgramStructure::findOrFail($id);
        $faculties = Faculty::all();
        return view('admin.program-structures.edit', compact('programStructure', 'faculties'));
    }

    public function update(Request $request, $id)
    {
        $programStructure = ProgramStructure::findOrFail($id);

        $request->validate([
            'program_name' => 'required|string',
            'faculty_id' => 'required|exists:faculties,id',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'academic_year' => 'required|string',
            'version' => 'nullable|string'
        ]);

        $data = $request->except('pdf_file');

        if ($request->hasFile('pdf_file')) {
            // Delete old file
            if ($programStructure->pdf_path) {
                Storage::disk('public')->delete($programStructure->pdf_path);
            }

            $data['pdf_path'] = $request->file('pdf_file')->store('program-structures', 'public');
        }

        $programStructure->update($data);

        return redirect()->route('admin.program-structures.index')
            ->with('success', 'Program structure updated successfully');
    }

    public function destroy($id)
    {
        $programStructure = ProgramStructure::findOrFail($id);

        // Delete PDF file
        if ($programStructure->pdf_path) {
            Storage::disk('public')->delete($programStructure->pdf_path);
        }

        $programStructure->delete();

        return redirect()->route('admin.program-structures.index')
            ->with('success', 'Program structure deleted successfully');
    }

    // Add this method if you want to toggle active status
    public function toggleStatus($id)
    {
        $programStructure = ProgramStructure::findOrFail($id);
        $programStructure->update([
            'is_active' => !$programStructure->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully',
            'is_active' => $programStructure->is_active
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'faculty_id' => 'required|exists:faculties,id',
            'pdf_file' => 'required|mimes:pdf|max:10240',
            'academic_year' => 'required|string',
            'version' => 'nullable|string'
        ]);

        // Get the program name from the selected program
        $program = Program::findOrFail($request->program_id);

        $path = $request->file('pdf_file')->store('program-structures', 'public');

        ProgramStructure::create([
            'program_id' => $request->program_id,
            'program_name' => $program->name, // Add this if you need to store program name
            'faculty_id' => $request->faculty_id,
            'pdf_path' => $path,
            'academic_year' => $request->academic_year,
            'version' => $request->version,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.program-structures.index')
            ->with('success', 'Program structure uploaded successfully');
    }
    public function getPrograms($faculty)
    {
        try {
            \Log::info('getPrograms called with faculty_id: ' . $faculty);

            $programs = Program::where('faculty_id', $faculty)
                ->select('id', 'name', 'code')
                ->get();

            \Log::info('Programs found: ' . $programs->count(), ['programs' => $programs->toArray()]);

            return response()->json($programs);
        } catch (\Exception $e) {
            \Log::error('Error in getPrograms: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $faculties = Faculty::with(['programs.programStructures' => function ($query) {
            $query->orderBy('academic_year', 'desc')
            ->orderBy('version', 'desc');
        }])->get();

        return view('admin.program-structures.list', compact('faculties'));
    }
}
