@extends('layouts.student')

@section('title', 'Minor Course Registration')

@section('content')
@php
\Log::info('View Data:', [
    'minorCourses' => isset($minorCourses) ? $minorCourses->count() : 'not set',
    'student' => isset($student) ? $student->id : 'not set',
]);
@endphp

@if(!$activeMinorPeriod)
    <div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
        <div class="container mx-auto max-w-4xl p-8">
            <div class="text-center animate-fadeIn">
                <!-- SVG Illustration -->
                <div class="mb-8 animate-float">
                    <svg class="mx-auto w-64 h-64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V5C20 3.89543 19.1046 3 18 3H6C4.89543 3 4 3.89543 4 5V19C4 20.1046 4.89543 21 6 21ZM16 11H8V7H16V11Z"
                            stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Message -->
                <h2 class="text-3xl font-bold text-gray-800 mb-4 animate-slideDown">
                    Minor Registration Closed
                </h2>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-lg mb-6 animate-slideUp">
                    <p class="text-xl text-red-700 font-medium">
                        Minor course registration is currently closed.
                    </p>
                    <p class="text-gray-600 mt-2">
                        Please check back during the next registration period.
                    </p>
                </div>

                <!-- Next Steps -->
                <div class="grid md:grid-cols-2 gap-6 mt-8 animate-fadeIn">
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Need Help?</h3>
                        <p class="text-gray-600">Contact your academic advisor for guidance</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Stay Updated</h3>
                        <p class="text-gray-600">Check the academic calendar for upcoming registration dates</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
        <div class="container mx-auto max-w-4xl p-8 bg-white rounded-xl shadow-lg">
            @if(isset($existingRegistration))
                <div class="bg-teal-50 border-l-4 border-teal-500 p-6 rounded-lg mb-6">
                    <h4 class="text-xl font-semibold text-teal-800 mb-4">Minor Registration Status</h4>
                    <p class="text-teal-700 text-lg mb-4">
                        @if($existingRegistration->status === 'pending')
                            Your minor registration application is currently pending approval.
                        @elseif($existingRegistration->status === 'approved')
                            Your minor registration application has been approved.
                        @elseif($existingRegistration->status === 'rejected')
                            Your minor registration application has been rejected.
                        @endif
                    </p>
                    <hr class="border-teal-200 my-4">
                    <div class="mt-3">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <p class="text-teal-700"><span class="font-medium">Course Code:</span> {{ $existingRegistration->course_code }}</p>
                                <p class="text-teal-700"><span class="font-medium">Course Name:</span> {{ $existingRegistration->course_name }}</p>
                                <p class="text-teal-700"><span class="font-medium">Faculty:</span> {{ $existingRegistration->faculty }}</p>
                            </div>
                            <div class="space-y-2">
                                <p class="text-teal-700">
                                    <span class="font-medium">Status:</span>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $existingRegistration->status === 'approved' ? 'bg-green-100 text-green-800' :
                                           ($existingRegistration->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ ucfirst($existingRegistration->status) }}
                                    </span>
                                </p>
                                @if($existingRegistration->dean_comments)
                                <p class="text-teal-700">
                                    <span class="font-medium">Dean's Comments:</span><br>
                                    <span class="italic">{{ $existingRegistration->dean_comments }}</span>
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-teal-100 border-l-4 border-teal-500 text-teal-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Title -->
                <h3 class="text-2xl font-bold text-teal-800 text-center mb-8">Minor Registration Form</h3>

                <!-- Registration Form Container -->
                <div class="space-y-6">
                    <form action="{{ route('student.minor-registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Main Content Container -->
                        <div class="container mx-auto max-w-4xl space-y-8">
                            <!-- Student Info Card -->
                            <div class="bg-teal-50 p-6 rounded-lg">
                                <h4 class="text-lg font-semibold text-teal-800 mb-4">Student Information</h4>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-teal-700">Student Name</label>
                                        <p class="text-lg text-teal-900">{{ $student->name }}</p>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-teal-700">Matric Number</label>
                                        <p class="text-lg text-teal-900">{{ $student->matric_number }}</p>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-teal-700">Current Semester</label>
                                        <p class="text-lg text-teal-900">{{ $student->current_semester }}</p>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-teal-700">Program Name</label>
                                        <p class="text-lg text-teal-900">{{ $student->program->name ?? 'Not assigned' }}</p>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-teal-700">Phone Number</label>
                                        <p class="text-lg text-teal-900">{{ $student->phone }}</p>
                                    </div>

                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-teal-700">Email</label>
                                        <p class="text-lg text-teal-900">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Available Minor Courses Table -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="bg-gradient-to-r from-teal-600 to-teal-500 px-6 py-4">
                                    <h4 class="text-lg font-semibold text-white">Available Minor Courses</h4>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-teal-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                                    Course Code
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                                    Course Name
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                                    Faculty
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                                    Credit Hours
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($minorCourses as $course)
                                            <tr class="hover:bg-teal-50/50 transition-colors duration-150">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="radio"
                                                           name="course_id"
                                                           value="{{ $course->id }}"
                                                           class="form-radio text-teal-600"
                                                           required>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-teal-700 text-center">
                                                    {{ $course->course_code }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                                    {{ $course->course_name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                                    {{ $course->faculty }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-900 text-center">
                                                    {{ $course->credit_hours }}
                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Empty State -->
                                @if($minorCourses->isEmpty())
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Minor Courses Available</h3>
                                    <p class="mt-1 text-sm text-gray-500">Please check back later for available minor courses.</p>
                                </div>
                                @endif

                                <!-- Pagination if needed -->
                                @if($minorCourses->hasPages())
                                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                                    {{ $minorCourses->links() }}
                                </div>
                                @endif
                            </div>

                            <!-- Semester Information Section -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                                <div class="bg-gradient-to-r from-teal-600 to-teal-500 px-6 py-4">
                                    <h4 class="text-lg font-semibold text-white">Semester Information</h4>
                                </div>
                                <div class="p-6">
                                    <div class="mb-4">
                                        <label for="proposed_semester" class="block text-sm font-medium text-gray-700 mb-2">
                                            Proposed Semester <span class="text-red-500">*</span>
                                        </label>
                                        <select name="proposed_semester" id="proposed_semester"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                                required>
                                            <option value="">Select Semester</option>
                                            @for ($i = 1; $i <= 8; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        @error('proposed_semester')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Form Upload Section -->
                            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                                <div class="bg-gradient-to-r from-teal-600 to-teal-500 px-6 py-4">
                                    <h4 class="text-lg font-semibold text-white">Required Documents</h4>
                                </div>

                                <div class="p-6 space-y-6">
                                    <!-- Signed Form Upload -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="signed_form" class="block text-sm font-medium text-gray-700">
                                                Signed Registration Form
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <span class="text-xs text-gray-500">PDF only, max 2MB</span>
                                        </div>
                                        <input type="file" name="signed_form" id="signed_form" accept=".pdf" class="hidden" required>
                                        <label for="signed_form" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-4 hover:border-teal-500 cursor-pointer">
                                            <div class="text-center" id="signed_form_display">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <span class="mt-2 block text-sm text-gray-600">Click to upload signed form</span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Academic Transcript Upload -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="transcript" class="block text-sm font-medium text-gray-700">
                                                Academic Transcript
                                                <span class="text-red-500">*</span>
                                            </label>
                                            <span class="text-xs text-gray-500">PDF only, max 2MB</span>
                                        </div>
                                        <input type="file" name="transcript" id="transcript" accept=".pdf" class="hidden" required>
                                        <label for="transcript" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-4 hover:border-teal-500 cursor-pointer">
                                            <div class="text-center" id="transcript_display">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <span class="mt-2 block text-sm text-gray-600">Click to upload transcript</span>
                                            </div>
                                        </label>
                                    </div>

                                    <!-- Additional Documents Upload -->
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <label for="additional_docs" class="block text-sm font-medium text-gray-700">
                                                Additional Supporting Documents
                                                <span class="text-gray-500 text-xs">(Optional)</span>
                                            </label>
                                            <span class="text-xs text-gray-500">PDF only, max 5MB</span>
                                        </div>
                                        <input type="file" name="additional_docs" id="additional_docs" accept=".pdf" class="hidden">
                                        <label for="additional_docs" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 p-4 hover:border-teal-500 cursor-pointer">
                                            <div class="text-center" id="additional_docs_display">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <span class="mt-2 block text-sm text-gray-600">Click to upload additional documents</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-4 mt-8">
                                <button type="button" id="downloadForm" class="flex-1 bg-white text-teal-600 border-2 border-teal-600 py-3 px-6 rounded-lg font-semibold hover:bg-teal-50 focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                                    Download Form
                                </button>

                                <button type="submit" class="flex-1 bg-teal-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-teal-700 focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                                    Submit Application
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle file selection display
            function handleFileSelect(inputId, displayId) {
                const input = document.getElementById(inputId);
                const display = document.getElementById(displayId);

                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        display.innerHTML = `
                            <svg class="mx-auto h-8 w-8 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="mt-2 block text-sm text-teal-600">${file.name}</span>
                        `;
                    }
                });
            }

            // Initialize file input displays
            handleFileSelect('signed_form', 'signed_form_display');
            handleFileSelect('transcript', 'transcript_display');
            handleFileSelect('additional_docs', 'additional_docs_display');

            // Download Form functionality
            const downloadFormBtn = document.getElementById('downloadForm');
            if (downloadFormBtn) {
                downloadFormBtn.addEventListener('click', function() {
                    // Replace with your actual form download URL
                    window.location.href = "{{ route('student.minor-registration.download-form') }}";
                });
            }

            // Form submission handling
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Basic validation
                    const requiredFields = form.querySelectorAll('[required]');
                    let isValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value) {
                            isValid = false;
                            field.classList.add('border-red-500');
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    if (isValid) {
                        // Show loading state
                        const submitBtn = form.querySelector('button[type="submit"]');
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Submitting...
                        `;

                        // Submit the form
                        form.submit();
                    } else {
                        // Show error message
                        alert('Please fill in all required fields');
                    }
                });
            }
        });
    </script>
@endpush
