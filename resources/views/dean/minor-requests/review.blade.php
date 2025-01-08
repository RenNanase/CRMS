@extends('layouts.app')

@push('styles')
<style>
    /* Form input styling */
    input,
    select,
    textarea {
        @apply border-2 border-gray-200 hover: border-teal-400;
    }
.card-hover {
    @apply transition-transform duration-300 hover:scale-[1.02] hover:shadow-lg;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 to-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-teal-800">Review Minor Application</h2>
                <div class="flex space-x-4">
                    <a href="{{ route('dean.minor-requests.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </a>


                        </div>
                    </div>
                </div>

        <!-- Main Content -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="p-8">
                <!-- Application Details Card -->
<!-- Application Details Card -->
            <div class="bg-gradient-to-r from-teal-50 to-teal-100 rounded-xl p-6 mb-8 card-hover">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h3 class="text-xl font-semibold text-teal-800">Student Application Details</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/50 rounded-lg p-4">
                        <p class="text-sm font-medium text-teal-600 mb-1">Student Name</p>
                        <p class="text-lg font-medium text-gray-900">{{ $minorRegistration->student->name }}</p>
                    </div>
                    <div class="bg-white/50 rounded-lg p-4">
                        <p class="text-sm font-medium text-teal-600 mb-1">Program</p>
                        <p class="text-lg font-medium text-gray-900">{{ $minorRegistration->student->program->name }}</p>
                    </div>
                    <div class="bg-white/50 rounded-lg p-4">
                        <p class="text-sm font-medium text-teal-600 mb-1">Matric Number</p>
                        <p class="text-lg font-medium text-gray-900">{{ $minorRegistration->student->matric_number }}</p>
                    </div>
                </div>
            </div>

<!-- PDF Viewer Card with Controls -->
            <div class="bg-white rounded-xl border-2 border-teal-100 p-6 mb-8 card-hover">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-teal-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-800">Student Application Form</h3>
                    </div>
                    @if($minorRegistration->signed_form_path)
                    <a href="{{ Storage::url($minorRegistration->signed_form_path) }}" target="_blank"
                        class="inline-flex items-center px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Open in New Tab
                    </a>
                    @endif
                </div>
                @if($minorRegistration->signed_form_path)
                <div class="border-2 border-teal-100 rounded-lg overflow-hidden shadow-inner">
                    <iframe src="{{ Storage::url($minorRegistration->signed_form_path) }}" class="w-full h-[600px]">
                    </iframe>
                </div>
                @else
                <div
                    class="flex flex-col items-center justify-center h-32 bg-gray-50 rounded-lg border-2 border-dashed border-gray-200">
                    <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="text-red-600">No application form uploaded</p>
                </div>
                @endif
            </div>

<!-- Recommendation Form -->
            <form action="{{ route('dean.minor-requests.recommendation', $minorRegistration) }}" method="POST" class="mt-6">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Dean's Name Field - Auto-populated -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Dean's Name
                        </label>
                        <input type="text" name="dean_name" value="{{ auth()->user()->name }}"
                            class="w-full h-10 rounded-lg bg-gray-50 px-3" readonly>
                    </div>

                    <!-- Recommendation Status Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Recommendation</label>
                        <select name="recommendation_status" class="w-full h-10 rounded-lg bg-white px-3 cursor-pointer" required>
                            <option value="">Select recommendation</option>
                            <option value="approved" class="text-green-600">Approve</option>
                            <option value="rejected" class="text-red-600">Reject</option>
                        </select>
                    </div>


<!-- Comments Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Comments
                        </label>
                        <textarea name="dean_comments" rows="4" class="w-full rounded-lg bg-white p-3"
                            placeholder="Enter your comments here..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-4 pt-6">
                        <button type="button"
                            onclick="window.location.href='{{ route('dean.minor-requests.index') }}'"
                            class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-all duration-200">
                            Submit Decision
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
