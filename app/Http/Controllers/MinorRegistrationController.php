<?php

namespace App\Http\Controllers;

use App\Models\MinorRegistration;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PDF;
use Illuminate\Support\Facades\Storage;
use App\Models\RegistrationPeriod;

class MinorRegistrationController extends Controller
{
    public function create()
    {
        \Log::info('Attempting to access minor registration create method');

        // Get active minor registration period
        $activeMinorPeriod = RegistrationPeriod::where('type', 'minor')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        \Log::info('Active minor period check:', ['active_period' => $activeMinorPeriod]);

        $student = Student::with('program')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        \Log::info('Student found:', [
            'student_id' => $student->id,
            'user_id' => Auth::id()
        ]);

        // Check if student has any pending or approved minor registration
        $existingRegistration = MinorRegistration::where('student_id', $student->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        \Log::info('Existing registration check:', ['existing_registration' => $existingRegistration]);

        // Get available minor courses
        $minorCourses = Course::where('type', 'minor')
            ->join('faculties', 'courses.faculty_id', '=', 'faculties.id')
            ->select(
                'courses.id',
                'courses.course_code',
                'courses.course_name',
                'courses.credit_hours',
                'faculties.faculty_name as faculty'
            )
            ->paginate(10);

        return view('student.minor-registration.create', [
            'student' => $student,
            'minorCourses' => $minorCourses,
            'activeMinorPeriod' => $activeMinorPeriod,  // Pass the variable to the view
            'existingRegistration' => $existingRegistration
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Check if minor registration is open
            $activeRegistration = RegistrationPeriod::where('type', 'minor')
            ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->first();

            if (!$activeRegistration) {
                return redirect()->back()->with('error', 'Minor course registration is currently closed.');
            }

            // Get the authenticated student with program and user relationships
            $student = Student::with(['program', 'user'])
            ->where('user_id', Auth::id())
                ->firstOrFail();

            // Check if student has any pending or approved minor registration
            $existingRegistration = MinorRegistration::where('student_id', $student->id)
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            if ($existingRegistration) {
                return redirect()->back()
                    ->with('error', 'You already have a ' . $existingRegistration->status . ' minor registration. You cannot submit another request until the current one is processed.');
            }

            // Simplified validation rules - only for required documents
            $validationRules = [
                'course_id' => 'required|exists:courses,id',
                'signed_form' => 'required|file|mimes:pdf|max:2048',
                'transcript' => 'required|file|mimes:pdf|max:2048',
                'additional_docs' => 'nullable|file|mimes:pdf|max:5120', // 5MB max
            ];

            // Validate the request
            $validated = $request->validate($validationRules);

            // Store files with proper directory structure
            Storage::disk('public')->makeDirectory('minor-registrations/signed-forms');
            Storage::disk('public')->makeDirectory('minor-registrations/transcripts');
            Storage::disk('public')->makeDirectory('minor-registrations/additional-docs');

            // Store signed form
            $signedFormPath = $request->file('signed_form')->store('minor-registrations/signed-forms', 'public');

            // Store transcript
            $transcriptPath = $request->file('transcript')->store('minor-registrations/transcripts', 'public');

            // Store additional docs if provided
            $additionalDocsPath = null;
            if ($request->hasFile('additional_docs')) {
                $additionalDocsPath = $request->file('additional_docs')->store('minor-registrations/additional-docs', 'public');
            }

            // Verify file storage
            if (!Storage::disk('public')->exists($signedFormPath) || !Storage::disk('public')->exists($transcriptPath)) {
                throw new \Exception('File failed to store properly');
            }

            // Log file uploads
            \Log::info('File uploads:', [
                'signed_form' => $signedFormPath,
                'transcript' => $transcriptPath,
                'additional_docs' => $additionalDocsPath
            ]);

            // Get the course details
            $course = Course::findOrFail($request->course_id);

            // Create the minor registration
            $minorRegistration = MinorRegistration::create([
                'student_id' => $student->id,
                'name' => $student->name,
                'matric_number' => $student->matric_number,
                'current_semester' => $student->current_semester,
                'program_name' => $student->program->name,
                'phone' => $student->phone,
                'email' => $student->user->email,
                'cgpa' => 0.00,
                'course_id' => $course->id,
                'course_code' => $course->course_code,
                'course_name' => $course->course_name,
                'faculty' => $course->faculty->faculty_name,
                'signed_form_path' => $signedFormPath,
                'transcript_path' => $transcriptPath,
                'additional_docs_path' => $additionalDocsPath,
                'registration_period_id' => $activeRegistration->id,
                'status' => 'pending'
            ]);

            \Log::info('Minor Registration Created:', [
                'id' => $minorRegistration->id,
                'signed_form_path' => $minorRegistration->signed_form_path,
                'transcript_path' => $minorRegistration->transcript_path,
                'additional_docs_path' => $minorRegistration->additional_docs_path
            ]);

            return redirect()->route('minor-registration.create')
            ->with('success', 'Your minor course registration has been submitted successfully! Please wait for the Dean\'s approval.');
        } catch (\Exception $e) {
            \Log::error('Minor Registration Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'There was an error submitting your registration: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function index()
    {
        $minorRegistrations = MinorRegistration::with(['student', 'student.program'])
            ->latest()
            ->paginate(10);

        return view('dean.minor-requests.index', compact('minorRegistrations'));
    }

    public function showRecommendation(MinorRegistration $minorRegistration)
    {
        if ($minorRegistration->status !== 'pending') {
            return redirect()->route('dean.minor-requests.index')
                ->with('error', 'This application has already been processed.');
        }

        // Add detailed debugging
        \Log::info('Accessing PDF file:', [
            'file_path' => $minorRegistration->signed_form_path,
            'storage_path' => Storage::disk('public')->path($minorRegistration->signed_form_path),
            'public_url' => Storage::disk('public')->url($minorRegistration->signed_form_path),
            'exists' => Storage::disk('public')->exists($minorRegistration->signed_form_path),
            'full_path_exists' => file_exists(Storage::disk('public')->path($minorRegistration->signed_form_path))
        ]);

        return view('dean.minor-requests.review', [
            'minorRegistration' => $minorRegistration
        ]);
    }

    public function approve(MinorRegistration $minorRegistration)
    {
        $minorRegistration->update([
            'status' => 'approved',
            'remarks' => request('remarks')
        ]);

        return redirect()->back()
            ->with('success', 'Minor registration request approved successfully.');
    }

    public function reject(MinorRegistration $minorRegistration)
    {
        $minorRegistration->update([
            'status' => 'rejected',
            'remarks' => request('remarks')
        ]);

        return redirect()->back()
            ->with('success', 'Minor registration application rejected successfully.');
    }

    public function updateRecommendation(Request $request, MinorRegistration $minorRegistration)
    {
        // Add logging to debug the incoming request
        \Log::info('Recommendation update request:', $request->all());

        $validated = $request->validate([
            'recommendation_status' => 'required|in:approved,rejected',
            'dean_comments' => 'nullable|string',
            'dean_name' => 'required|string'
        ]);

        try {
            // Update the minor registration
            $minorRegistration->update([
                'status' => $validated['recommendation_status'],
                'dean_comments' => $validated['dean_comments'],
                'dean_name' => $validated['dean_name'],
                'recommendation_date' => now()
            ]);

            \Log::info('Minor Registration updated successfully:', [
                'id' => $minorRegistration->id,
                'new_status' => $validated['recommendation_status']
            ]);

            return redirect()->route('dean.minor-requests.index')
                ->with('success', 'Minor registration request ' . ucfirst($validated['recommendation_status']) . ' successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating recommendation:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to update recommendation: ' . $e->getMessage());
        }
    }

    public function generatePdf(Request $request)
    {
        try {
            // Get the authenticated student with relationships
            $student = Student::with(['program', 'user'])
                ->where('user_id', auth()->id())
                ->firstOrFail();

            // Get the selected course with faculty
            $course = Course::with('faculty')
            ->findOrFail($request->course_id);

            // Get current academic period
            $academicPeriod = RegistrationPeriod::where('type', 'minor')
            ->where('status', 'active')
            ->first();

            // Prepare data for PDF
            $data = [
                'student' => $student, // Pass the entire student model
                'course' => $course,   // Pass the entire course model
                'academic_session' => $academicPeriod ? $academicPeriod->academic_period->name : now()->year . '/' . (now()->year + 1),
                'proposed_semester' => $request->proposed_semester,
                'academic_records' => [
                    'semester1_gpa' => $request->semester1_gpa,
                    'semester2_gpa' => $request->semester2_gpa,
                    'semester3_gpa' => $request->semester3_gpa,
                    'semester4_gpa' => $request->semester4_gpa,
                    'cgpa' => $request->cgpa,
                ]
            ];

            \Log::info('PDF Generation Data:', $data);

            // Configure PDF
            $pdf = PDF::loadView('pdfs.minor-registration-form', $data);
            $pdf->setPaper('a4');

            // Generate filename
            $filename = 'minor_registration_' . $student->matric_number . '_' . date('Y-m-d_His') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('PDF Generation Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Failed to generate PDF. Please try again.');
        }
    }

    // Add this new method to your controller
    public function cancel(MinorRegistration $minorRegistration)
    {
        try {
            // Log the attempt
            \Log::info('Cancel attempt:', [
                'user_id' => auth()->id(),
                'student_id' => auth()->user()->student->id ?? null,
                'registration_id' => $minorRegistration->id
            ]);

            // First check if user is authenticated and has a student record
            if (!auth()->user() || !auth()->user()->student) {
                \Log::warning('Cancel failed: No student record', ['user_id' => auth()->id()]);
                return redirect()->back()->with('error', 'Student record not found.');
            }

            // Then check if the registration belongs to the authenticated student
            if ($minorRegistration->student_id !== auth()->user()->student->id) {
                \Log::warning('Cancel failed: Unauthorized', [
                    'student_id' => auth()->user()->student->id,
                    'registration_id' => $minorRegistration->id
                ]);
                return redirect()->back()->with('error', 'Unauthorized action.');
            }

            // Only allow cancellation of pending applications
            if ($minorRegistration->status !== 'pending') {
                \Log::warning('Cancel failed: Invalid status', [
                    'status' => $minorRegistration->status,
                    'registration_id' => $minorRegistration->id
                ]);
                return redirect()->back()->with('error', 'Only pending applications can be cancelled.');
            }

            // Fix: Add quotes around the values
            $minorRegistration->update([
                'status' => 'cancelled',  // Make sure this matches your enum/validation
                'remarks' => 'Cancelled by student'
            ]);

            \Log::info('Registration cancelled successfully', [
                'registration_id' => $minorRegistration->id,
                'student_id' => auth()->user()->student->id
            ]);

            return redirect()->back()->with('success', 'Your minor registration application has been cancelled.');
        } catch (\Exception $e) {
            \Log::error('Error cancelling minor registration:', [
                'error' => $e->getMessage(),
                'registration_id' => $minorRegistration->id,
                'student_id' => auth()->user()->student->id ?? null
            ]);

            return redirect()->back()->with('error', 'An error occurred while cancelling the application.');
        }
    }

    public function destroy(MinorRegistration $minorRegistration)
    {
        // Check if the registration belongs to the authenticated student
        if ($minorRegistration->student_id !== auth()->user()->student->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Only allow deletion of rejected or cancelled applications
        if (!in_array($minorRegistration->status, ['rejected', 'cancelled'])) {
            return redirect()->back()->with('error', 'Only rejected or cancelled applications can be deleted.');
        }

        try {
            // Delete the signed form file if it exists
            if ($minorRegistration->signed_form_path && Storage::disk('public')->exists($minorRegistration->signed_form_path)) {
                Storage::disk('public')->delete($minorRegistration->signed_form_path);
            }

            // Delete the registration
            $minorRegistration->delete();

            return redirect()->back()->with('success', 'Minor registration application has been deleted successfully. You can now apply for a new minor course.');
        } catch (\Exception $e) {
            \Log::error('Error deleting minor registration:', [
                'error' => $e->getMessage(),
                'registration_id' => $minorRegistration->id
            ]);

            return redirect()->back()->with('error', 'An error occurred while deleting the application.');
        }
    }
}
