@php
\Log::info('View Data:', [
'minorCourses' => isset($minorCourses) ? $minorCourses->count() : 'not set',
'student' => isset($student) ? $student->id : 'not set',
]);
@endphp

@extends('layouts.student')

@section('title', 'Minor Course Registration')

@section('content')
    @php
        $activeMinorPeriod = App\Models\RegistrationPeriod::where('type', 'minor')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
    @endphp

    @if(!$activeMinorPeriod)
        <div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
            <div class="container mx-auto max-w-4xl p-8">
                <div class="text-center animate-fadeIn">
                    <!-- SVG Illustration -->
                    <div class="mb-8 animate-float">
                        <svg class="mx-auto w-64 h-64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V5C20 3.89543 19.1046 3 18 3H6C4.89543 3 4 3.89543 4 5V19C4 20.1046 4.89543 21 6 21ZM16 11H8V7H16V11Z"
                                  stroke="#EF4444"
                                  stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
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

        <style>
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
                100% { transform: translateY(0px); }
            }

            @keyframes slideDown {
                from { transform: translateY(-20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            @keyframes slideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }

            .animate-float {
                animation: float 6s ease-in-out infinite;
            }

            .animate-slideDown {
                animation: slideDown 0.5s ease-out;
            }

            .animate-slideUp {
                animation: slideUp 0.5s ease-out;
            }

            .animate-fadeIn {
                animation: fadeIn 1s ease-out;
            }
        </style>
    @else
        <div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
            <div class="container mx-auto max-w-4xl p-8 bg-white rounded-xl shadow-lg">
                @if(isset($existingRegistration))
                    <div class="bg-teal-50 border-l-4 border-teal-500 p-6 rounded-lg mb-6">
                        <h4 class="text-xl font-semibold text-teal-800 mb-4">Minor Registration Status</h4>
                        <p class="text-teal-700 text-lg mb-4">{{ $message }}</p>
                        <hr class="border-teal-200 my-4">
                        <div class="mt-3">
                            <h5 class="font-semibold text-teal-800 mb-3">Course Details:</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <p class="text-teal-700"><span class="font-medium">Course Code:</span> {{ $existingRegistration->course_code }}</p>
                                    <p class="text-teal-700"><span class="font-medium">Course Name:</span> {{ $existingRegistration->course_name }}</p>
                                    <p class="text-teal-700"><span class="font-medium">Faculty:</span> {{ $existingRegistration->student->program->name }}</p>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-teal-700">
                                        <span class="font-medium">Status:</span>
                                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                            {{ $existingRegistration->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
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
                    <form action="{{ route('student.minor-registration.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Student Info Cards -->
                        <div class="grid md:grid-cols-2 gap-6 mb-8">
                            <!-- Personal Information -->
                            <div class="bg-teal-50 p-6 rounded-lg col-span-2">
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
                        </div>

                        <!-- Academic Records Section -->
                        <div class="space-y-6 bg-teal-50 p-6 rounded-lg">
                            <h4 class="text-lg font-semibold text-teal-800">Academic Records</h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @php
                                $currentSemester = (int) str_replace('Semester ', '', $student->current_semester);
                                @endphp

                                @for($i = 1; $i <= 4; $i++)
                                <div class="form-group">
                                    <label class="block text-sm font-semibold text-teal-700 mb-2">
                                        Semester {{ $i }} GPA
                                        @if($i <= $currentSemester) <span class="ml-2 text-xs text-red-600">*Required</span>
                                            @endif
                                    </label>
                                    <div class="relative">
                                        <input type="number" step="0.01" name="semester{{ $i }}_gpa"
                                            class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                                            {{ $i <=$currentSemester ? 'required' : '' }} min="0" max="4.00"
                                            placeholder="Enter GPA (0.00 - 4.00)" {{ $i> $currentSemester ? 'disabled' : '' }}>
                                    </div>
                                </div>
                                @endfor

                                <div class="col-span-full">
                                    <label class="block text-sm font-semibold text-teal-700 mb-2">
                                        Current CGPA
                                        <span class="ml-2 text-xs text-red-600">*Required</span>
                                    </label>
                                    <input type="number" step="0.01" name="cgpa" required min="0" max="4.00"
                                        class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                                        placeholder="Enter your current CGPA">
                                </div>
                            </div>

                        </div>

                        <!-- Programme Selection Section -->
                        <div class="space-y-6">
                            <div class="form-group">
                                <label for="minor_course" class="block text-sm font-semibold text-teal-700 mb-2">
                                    Select Minor Course
                                    <span class="ml-2 text-xs text-red-600">*Required</span>
                                </label>
                                <select name="course_id" id="minor_course" required
                                    class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200">
                                    <option value="">-- Select a minor course --</option>
                                    @foreach($minorCourses as $course)
                                    <option value="{{ $course->id }}">
                                        {{ $course->course_code }} - {{ $course->course_name }} ({{ $course->faculty }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="proposed_semester" class="block text-sm font-semibold text-teal-700 mb-2">
                                    Proposed Start Semester
                                    <span class="ml-2 text-xs text-red-600">*Required</span>
                                </label>
                                <input type="text" name="proposed_semester" id="proposed_semester" required
                                    class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                                    placeholder="e.g., Semester 9">
                            </div>

                        </div>

                        <!-- Head of Programme Section (For Preview Only) -->
                        <div class="mt-8 p-6 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Head of Programme Approval Section</h4>
                            <p class="text-sm text-gray-600 mb-4">This section needs to be filled manually by your Head of Programme
                                after
                                downloading the form.</p>

                            <div class="space-y-4">
                                <div class="p-4 bg-white rounded border border-gray-200">
                                    <p class="font-medium text-gray-700">Comments: _________________________________</p>
                                    <p class="mt-6 font-medium text-gray-700">Name: _________________________________</p>
                                    <p class="mt-6 font-medium text-gray-700">Signature: _____________________________</p>
                                    <p class="mt-6 font-medium text-gray-700">Date: _________________________________</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col md:flex-row gap-4 mt-8">
                            <button type="button" id="downloadForm"
                                class="flex-1 bg-white text-teal-600 border-2 border-teal-600 py-3 px-6 rounded-lg font-semibold hover:bg-teal-50 focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                                Download Form
                            </button>

                            <!-- Form Upload and Submit -->
                            <div class="flex-1">
                                <input type="file" name="signed_form" id="signed_form" accept=".pdf" class="hidden" required>
                                <label for="signed_form"
                                    class="block w-full text-center bg-teal-100 text-teal-700 py-3 px-6 rounded-lg font-semibold hover:bg-teal-200 cursor-pointer focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                                    Upload Signed Form
                                </label>
                                <p class="mt-2 text-sm text-gray-500 text-center" id="fileNameDisplay">No file chosen</p>
                            </div>

                            <button type="submit"
                                class="flex-1 bg-teal-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-teal-700 focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                                Submit to Dean
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
            // Download Form
            document.getElementById('downloadForm').addEventListener('click', function() {
                // Get form data
                const formData = new FormData(document.querySelector('form'));

                // Send to server to generate PDF
                fetch('{{ route("student.minor-registration.generate-pdf") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.blob())
                .then(blob => {
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = 'minor-registration-form.pdf';
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                });
            });

            // Display filename when selected
            document.getElementById('signed_form').addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                document.getElementById('fileNameDisplay').textContent = fileName;
            });
        });
</script>
@endpush
