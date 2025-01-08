<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #0d9488;
            border-radius: 0.5rem;
            padding: 0.5rem;
            min-height: 3rem;
            background-color: #fff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ccfbf1;
            border: none;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            color: #0f766e;
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #0f766e;
            margin-right: 0.5rem;
        }

        .select2-dropdown {
            border-color: #0d9488;
            border-radius: 0.5rem;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #0d9488;
        }

        .form-input-focus {
            @apply focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 via-white to-teal-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()" 
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-300 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-teal-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-700 p-6">
                <h1 class="text-3xl font-bold text-white tracking-wide">Edit Course</h1>
                <p class="text-teal-100 mt-2">Fill in the course details below</p>
            </div>

            <!-- Form -->
            <form action="{{ route('courses.update', $course->id) }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Two Column Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Course Name -->
                    <div class="form-group">
                        <label for="course_name" class="block text-sm font-medium text-gray-700 mb-2">Course Name</label>
                        <input type="text" name="course_name" id="course_name"
                               class="w-full px-4 py-2 rounded-lg border border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300"
                               placeholder="Enter course name"
                               required>
                    </div>

                    <!-- Course Code -->
                    <div class="form-group">
                        <label for="course_code" class="block text-sm font-medium text-gray-700 mb-2">Course Code</label>
                        <input type="text" name="course_code" id="course_code"
                               class="w-full px-4 py-2 rounded-lg border border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300"
                               placeholder="Enter course code"
                               required>
                    </div>

                    <!-- Credit Hours -->
                    <div class="form-group">
                        <label for="credit_hours" class="block text-sm font-medium text-gray-700 mb-2">Credit Hours</label>
                        <input type="number" name="credit_hours" id="credit_hours"
                               class="w-full px-4 py-2 rounded-lg border border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300"
                               placeholder="Enter credit hours"
                               required>
                    </div>

                    <!-- Capacity -->
                    <div class="form-group">
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                        <input type="number" name="capacity" id="capacity"
                               class="w-full px-4 py-2 rounded-lg border border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300"
                               placeholder="Enter course capacity">
                    </div>
                </div>

                <!-- Full Width Inputs -->
                <div class="space-y-6">
                    <!-- Faculty -->
                    <div class="form-group">
                        <label for="faculty_id" class="block text-sm font-medium text-gray-700 mb-2">Faculty</label>
                        <select name="faculty_id" id="faculty_id"
                                class="w-full px-4 py-2 rounded-lg border border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300"
                                required>
                            <option value="">Select Faculty</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Prerequisites -->
                    <div class="form-group">
                        <label for="prerequisites" class="block text-sm font-medium text-gray-700 mb-2">Prerequisites</label>
                        <select name="prerequisite_ids[]" id="prerequisites" multiple
                                class="w-full rounded-lg border border-teal-300">
                            @foreach($courses as $prerequisite)
                                <option value="{{ $prerequisite->id }}">{{ $prerequisite->course_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Course Type -->
                    <div class="form-group">
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Course Type</label>
                        <select name="type" id="type"
                                class="w-full px-4 py-2 rounded-lg border border-teal-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-300"
                                required>
                            <option value="major">Major</option>
                            <option value="minor">Minor</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-teal-100">
                    <button type="button" onclick="window.history.back()"
                            class="px-6 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 rounded-lg bg-teal-600 text-white hover:bg-teal-700 transition-all duration-300 shadow-md hover:shadow-lg">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#prerequisites').select2({
                placeholder: "Select prerequisites",
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });

            $('#faculty_id').select2({
                placeholder: "Select faculty",
                allowClear: true,
                width: '100%',
                theme: 'classic'
            });
        });
    </script>
</body>
</html>