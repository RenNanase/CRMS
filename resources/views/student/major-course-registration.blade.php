@php
    \Log::info('View Data:', [
        'majorCourses' => isset($majorCourses) ? $majorCourses->count() : 'not set',
        'student' => isset($student) ? $student->id : 'not set',
    ]);
@endphp

@extends('layouts.student')

@section('title', 'Major Course Registration')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
    <div class="container mx-auto max-w-4xl p-8 bg-white rounded-xl shadow-lg">
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

        <!-- Registration Form Container -->
        <div class="space-y-6">
            <h3 class="text-2xl font-bold text-teal-800 text-center mb-8">Major Registration Form</h3>

            <form action="{{ route('course-requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}" />

                <!-- Student Info Cards -->
                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-teal-50 p-4 rounded-lg">
                        <label class="block text-sm font-semibold text-teal-700 mb-2">Student Status</label>
                        <p class="text-lg text-teal-900">{{ $studentStatus ? 'Scholarship' : 'Non-Scholarship' }}</p>
                        <input type="hidden" name="student_status" value="{{ $studentStatus ? 'scholarship' : 'non-scholarship' }}" />
                    </div>

                    <div class="bg-teal-50 p-4 rounded-lg">
                        <label class="block text-sm font-semibold text-teal-700 mb-2">Matric Number</label>
                        <p class="text-lg text-teal-900">{{ $matricNumber }}</p>
                        <input type="hidden" name="matric_number" value="{{ $matricNumber }}" />
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="space-y-6">

<!-- Replace the program input field with this -->
<div class="form-group">
    <label for="program" class="block text-sm font-semibold text-teal-700 mb-2">Program</label>
    <input type="text" name="program" id="program" value="{{ $student->program->name ?? 'Not Assigned' }}"
        class="w-full px-4 py-2 bg-gray-50 border border-teal-200 rounded-lg" readonly />
</div>

<!-- Replace the request type field with this -->
<input type="hidden" name="request_type" value="major" />

                    <!-- Fee Receipt Section -->
                    <div id="fee-receipt" class="form-group">
                        <label for="fee_receipt" class="block text-sm font-semibold text-teal-700 mb-2">Upload Fee Receipt</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="w-full flex flex-col items-center px-4 py-6 bg-teal-50 text-teal-700 rounded-lg tracking-wide border-2 border-dashed border-teal-200 cursor-pointer hover:bg-teal-100 transition duration-200">
                                <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                </svg>
                                <span class="mt-2 text-sm">Select a file</span>
                                <input type="file" name="fee_receipt" id="fee_receipt" class="hidden" accept=".pdf,.jpg,.jpeg,.png" />
                            </label>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">Accepted file types: PDF, JPG, JPEG, PNG</p>
                        @if(!$studentStatus)
                            <p class="mt-2 text-sm text-red-500">*Required for non-scholarship students</p>
                        @endif
                    </div>

                    <!-- Course Selection -->
                    <div class="form-group">
                        <label for="course" class="block text-sm font-semibold text-teal-700 mb-2">Select Course</label>
                        <select name="course" id="course" required
                                class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200">
                            <option value="">-- Select a course --</option>
                            @if(isset($majorCourses) && $majorCourses->isNotEmpty())
                                @foreach($majorCourses as $course)
                                    <option value="{{ $course->id }}" data-code="{{ $course->course_code }}">
                                        {{ $course->course_name }} ({{ $course->course_code }})
                                    </option>
                                @endforeach
                            @else
                                <option value="">No major courses available</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="block text-sm font-semibold text-teal-700 mb-2">Course Code</label>
                        <input type="text" id="courseCode" name="course_code"
                               class="w-full px-4 py-2 bg-gray-50 border border-teal-200 rounded-lg" readonly />
                    </div>

                    <div id="group-info" class="form-group">
                        <label class="block text-sm font-semibold text-teal-700 mb-2">Course Group</label>
                        <div id="group-display" class="p-4 bg-teal-50 rounded-lg text-teal-700">
                            No group selected
                        </div>
                        <input type="hidden" name="group_id" id="group_id" value="">
                    </div>

                    <div id="prerequisites" class="bg-teal-50 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-teal-700 mb-2">Prerequisites</h4>
                        <div class="text-teal-600">Loading prerequisites...</div>
                    </div>

                    <button type="submit"
                            class="w-full bg-teal-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-teal-700 focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                        Submit Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('course').addEventListener('change', function() {
    const courseId = this.value;
    const groupDisplay = document.getElementById('group-display');
    const courseCodeInput = document.getElementById('courseCode');

    // Reset displays when no course is selected
    if (!courseId) {
        groupDisplay.textContent = 'No group selected';
        document.getElementById('group_id').value = '';
        document.getElementById('prerequisites').innerHTML = '';
        courseCodeInput.value = '';
        return;
    }

    // Set course code
    const selectedOption = this.options[this.selectedIndex];
    const courseCode = selectedOption.getAttribute('data-code');
    courseCodeInput.value = courseCode;

    // Fetch group information
    fetch(`/courses/${courseId}/group`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('group_id').value = data.group_id;
            groupDisplay.textContent = data.group_name || 'Group ' + data.group_id;
        })
        .catch(error => {
            console.error('Error fetching group:', error);
            groupDisplay.innerHTML = '<span class="text-red-500">Error loading group information</span>';
        });

    // Fetch prerequisites
    fetch(`/course-prerequisites/${courseId}`)
        .then(response => response.json())
        .then(data => {
            const prerequisitesDiv = document.getElementById('prerequisites');
            prerequisitesDiv.innerHTML = '';

            if (data.error) {
                prerequisitesDiv.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                return;
            }

            if (data.prerequisites && data.prerequisites.length > 0) {
                const list = document.createElement('ul');
                list.className = 'list-disc pl-5 space-y-2';

                data.prerequisites.forEach(prerequisite => {
                    const listItem = document.createElement('li');
                    listItem.textContent = prerequisite.course_name;
                    list.appendChild(listItem);
                });

                prerequisitesDiv.appendChild(list);
            } else {
                prerequisitesDiv.innerHTML = `<p>No prerequisites for this course.</p>`;
            }
        })
        .catch(error => {
            console.error('Error fetching prerequisites:', error);
            document.getElementById('prerequisites').innerHTML =
                '<p class="text-red-500">Error loading prerequisites</p>';
        });
});

// Add this new code for file upload handling
document.getElementById('fee_receipt').addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name;
    if (fileName) {
        const fileLabel = this.previousElementSibling;
        fileLabel.textContent = fileName;
    }
});

// Toggle fee receipt visibility based on student status
document.getElementById('request_type').addEventListener('change', function() {
    const feeReceiptDiv = document.getElementById('fee-receipt');
    const feeReceiptInput = document.getElementById('fee_receipt');

    if (!{{ $studentStatus ? 'true' : 'false' }}) {
        feeReceiptDiv.style.display = 'block';
        feeReceiptInput.required = true;
    }
});
</script>
@endsection
