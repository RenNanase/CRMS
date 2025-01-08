<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Timetable</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        teal: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            600: '#0d9488',
                            700: '#0f766e'
                        }
                    }
                }
            }
        }
    </script>
</head>
@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
    {{ session('error') }}
</div>
@endif
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Create New Timetable</h2>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <!-- Form Section -->
            <div class="p-6">
                <form action="{{ route('admin.timetables.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Course Selection -->
                    <div class="col-span-2">
                        <label for="course_id" class="block text-sm font-medium text-teal-700">Course</label>
                        <select name="course_id" id="course_id"
                                class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                onchange="updateCourseInfo(this.value)"
                                required>
                            <option value="">Select a course</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                        data-code="{{ $course->course_code }}"
                                        data-lecturers="{{ $course->lecturers->pluck('id','name') }}">
                                    {{ $course->course_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Selection -->
<div class="form-group">
    <label for="type_display">Type</label>
    <input type="text" id="type_display" class="form-control" readonly>
    <input type="hidden" name="type" id="type" value="">
</div>

                    <!-- Lecturer Selection -->
                    <div class="col-span-2">
                        <label for="lecturer_id" class="block text-sm font-medium text-teal-700">Lecturer</label>
                        <select name="lecturer_id" id="lecturer_id"
                                class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                required>
                            <option value="">Select a lecturer</option>
                            </select>
                        </div>

                        <!-- Course Code (Read-only) -->
                    <div>
                        <label for="course_code" class="block text-sm font-medium text-teal-700">Course Code</label>
                        <input type="text" name="course_code" id="course_code"
                               class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-gray-200 bg-gray-50 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                               readonly>
                    </div>

                        <!-- Day of Week -->
                        <div>
                            <label for="day_of_week" class="block text-sm font-medium text-teal-700">Day of Week</label>
                            <select name="day_of_week" id="day_of_week"
                                    class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    required>
                                <option value="">Select a day</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                                <option value="Sunday">Sunday</option>
                            </select>
                        </div>

                        <!-- Time Selection -->
                        <div>
                            <label for="start_time" class="block text-sm font-medium text-teal-700">Start Time</label>
                            <input type="time" name="start_time" id="start_time"
                                   class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                   required>
                        </div>

                        <div>
                            <label for="end_time" class="block text-sm font-medium text-teal-700">End Time</label>
                            <input type="time" name="end_time" id="end_time"
                                   class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                   required>
                        </div>

                        <!-- Place -->
                        <div class="col-span-2">
                            <label for="place" class="block text-sm font-medium text-teal-700">Select Place</label>
                            <select id="place" name="place" class="mt-1 block w-full py-3 px-4 text-lg rounded-md border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                            required>
                            <option value="">Select a place</option>
                                @foreach($places as $place)
                                    <option value="{{ $place->name }}">{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    <!-- Submit Button -->
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                                class="bg-teal-600 text-white px-6 py-3 text-lg rounded-md hover:bg-teal-700 transition duration-150">
                            Create Timetable
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

            <!-- Update JavaScript section -->
    <script>
        function updateCourseInfo(courseId) {
            const courseSelect = document.getElementById('course_id');
            const courseCodeInput = document.getElementById('course_code');
            const lecturerSelect = document.getElementById('lecturer_id');
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];

            // Update course code
            courseCodeInput.value = selectedOption.dataset.code || '';

            // Update lecturers
            const lecturers = JSON.parse(selectedOption.dataset.lecturers || '{}');

            // Clear current options
            lecturerSelect.innerHTML = '<option value="">Select a lecturer</option>';

            // Add new options based on the selected course
            Object.entries(lecturers).forEach(([name, id]) => {
                const option = new Option(name, id);
                lecturerSelect.add(option);
            });

            // Enable/disable the lecturer select based on whether a course is selected
            lecturerSelect.disabled = !courseId;
        }
    </script>

    <script>
        // Add this after your existing scripts
    const courses = @json($courses);  // Convert courses collection to JavaScript object

    document.addEventListener('DOMContentLoaded', function() {
        const courseSelect = document.getElementById('course_id');
        const typeDisplay = document.getElementById('type_display');

        // Initial load
        updateCourseType();

        // On course change
        courseSelect.addEventListener('change', updateCourseType);

        function updateCourseType() {
            const selectedCourseId = courseSelect.value;
            if (selectedCourseId) {
                const selectedCourse = courses.find(course => course.id == selectedCourseId);
                if (selectedCourse) {
                    typeDisplay.value = selectedCourse.type;
                }
            } else {
                typeDisplay.value = '';
            }
        }
    });
    </script>


</body>
</html>
