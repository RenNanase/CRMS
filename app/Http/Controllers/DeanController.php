<?php

namespace App\Http\Controllers;

use App\Models\MinorRegistration;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\News;
use App\Models\Student;
use App\Models\Event;

class DeanController extends Controller
{


    public function dashboard()
    {
        $facultyId = auth()->user()->faculty_id;

        $data = [
            'pendingRequests' => MinorRegistration::whereHas('course', function ($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId);
            })
                ->where('status', 'pending')
                ->count(),

            // Fixed: Use direct role column instead of relationship
            'totalStudents' => User::where('role', 'student')
            ->where('faculty_id', $facultyId)
                ->count(),

            'totalCourses' => Course::where('faculty_id', $facultyId)
                ->count(),

            // Fixed: Use direct role column
            'facultyMembers' => User::where('role', 'lecturer')
            ->where('faculty_id', $facultyId)
                ->count(),

            'recentRequests' => MinorRegistration::whereHas('course', function ($query) use ($facultyId) {
                $query->where('faculty_id', $facultyId);
            })
                ->with(['student', 'course'])
                ->latest()
                ->take(5)
                ->get(),

            'latestNews' => News::latest()
                ->take(5)
                ->get(),

            'events' => Event::latest()
                ->orderBy('start_date')
                ->take(5)
                ->get()
        ];

        // Add debug logging
        \Log::info('Dashboard data:', [
            'faculty_id' => $facultyId,
            'counts' => [
                'pending' => $data['pendingRequests'],
                'students' => $data['totalStudents'],
                'courses' => $data['totalCourses'],
                'faculty' => $data['facultyMembers']
            ]
        ]);

        return view('dean.dashboard', $data);
    }
    // Update showMinorRequest method to include necessary relationships
    public function showMinorRequest(MinorRegistration $minorRegistration)
    {

        \Log::info('Dean Reviewing Minor Registration:', [
            'registration_id' => $minorRegistration->id,
            'file_path' => $minorRegistration->signed_form_path,
            'storage_exists' => Storage::disk('public')->exists($minorRegistration->signed_form_path),
            'public_exists' => file_exists(public_path('storage/' . $minorRegistration->signed_form_path)),
            'storage_files' => Storage::disk('public')->files('minor-registrations'),
        ]);

        // Verify the request belongs to dean's faculty
        if ($minorRegistration->course->faculty_id !== auth()->user()->faculty_id) {
            \Log::warning('Unauthorized minor request access:', [
                'dean_id' => auth()->id(),
                'request_id' => $minorRegistration->id
            ]);
            abort(403, 'Unauthorized access to this minor request.');
        }

        $minorRegistration->load(['student.user', 'course']);

        return view('dean.minor-requests.review', [
            'minorRegistration' => $minorRegistration
        ]);
    }

    // Add validation for dean_name in updateMinorRequest
    public function updateMinorRequest(Request $request, MinorRegistration $minorRegistration)
    {
        // Verify the request belongs to dean's faculty
        if ($minorRegistration->course->faculty_id !== auth()->user()->faculty_id) {
            \Log::warning('Unauthorized minor request update:', [
                'dean_id' => auth()->id(),
                'request_id' => $minorRegistration->id
            ]);
            abort(403);
        }

        try {
            $validated = $request->validate([
                'recommendation_status' => 'required|in:approved,rejected',
                'dean_comments' => 'nullable|string|max:1000',
                'dean_name' => 'required|string|max:255'
            ]);

            $minorRegistration->update([
                'status' => $validated['recommendation_status'],
                'dean_comments' => $validated['dean_comments'],
                'dean_name' => $validated['dean_name'],
                'recommendation_date' => now()
            ]);

            \Log::info('Minor request updated:', [
                'request_id' => $minorRegistration->id,
                'status' => $validated['recommendation_status'],
                'dean_id' => auth()->id()
            ]);

            return redirect()->route('dean.minor-requests.index')
            ->with('success', 'Minor request has been ' . $validated['recommendation_status']);
        } catch (\Exception $e) {
            \Log::error('Error updating minor request:', [
                'error' => $e->getMessage(),
                'request_id' => $minorRegistration->id
            ]);

            return back()->with('error', 'An error occurred while updating the request.');
        }
    }



    public function minorRequests()
    {
        $facultyId = auth()->user()->faculty_id;

        $minorRegistrations = MinorRegistration::whereHas('course', function ($query) use ($facultyId) {
            $query->where('faculty_id', $facultyId);
        })->latest()->paginate(10);

        return view('dean.minor-requests.index', compact('minorRegistrations'));
    }

    public function approveMinorRequest(Request $request, MinorRegistration $minorRequest)
    {
        try {
            $validated = $request->validate([
                'dean_comments' => 'nullable|string',
            ]);

            $minorRequest->update([
                'status' => 'approved',
                'dean_comments' => $validated['dean_comments'],
                'dean_name' => auth()->user()->name,
                'recommendation_date' => now()
            ]);

            Log::info('Minor request approved:', [
                'request_id' => $minorRequest->id,
                'dean_id' => auth()->id()
            ]);

            return redirect()->route('dean.minor-requests.index')
                ->with('success', 'Minor request has been approved successfully.');
        } catch (\Exception $e) {
            Log::error('Error approving minor request:', [
                'error' => $e->getMessage(),
                'request_id' => $minorRequest->id
            ]);

            return back()->with('error', 'Failed to approve request: ' . $e->getMessage());
        }
    }

    public function rejectMinorRequest(Request $request, MinorRegistration $minorRequest)
    {
        try {
            $validated = $request->validate([
                'dean_comments' => 'required|string',
            ]);

            $minorRequest->update([
                'status' => 'rejected',
                'dean_comments' => $validated['dean_comments'],
                'dean_name' => auth()->user()->name,
                'recommendation_date' => now()
            ]);

            Log::info('Minor request rejected:', [
                'request_id' => $minorRequest->id,
                'dean_id' => auth()->id()
            ]);

            return redirect()->route('dean.minor-requests.index')
                ->with('success', 'Minor request has been rejected.');
        } catch (\Exception $e) {
            Log::error('Error rejecting minor request:', [
                'error' => $e->getMessage(),
                'request_id' => $minorRequest->id
            ]);

            return back()->with('error', 'Failed to reject request: ' . $e->getMessage());
        }
    }


}
