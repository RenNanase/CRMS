<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Lecturer</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition duration-300 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()"
                    class="inline-flex items-center px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-300 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-8 py-6">
                <h2 class="text-3xl font-bold">Add New Lecturer</h2>
                <p class="mt-2 text-teal-100">Fill in the details to create a new lecturer profile</p>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                <form action="{{ route('lecturers.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Personal Information -->
                        <div class="space-y-6">
                            <div class="bg-teal-50 p-6 rounded-xl">
                                <h3 class="text-xl font-semibold text-teal-700 border-b-2 border-teal-200 pb-3 mb-6">Personal Information</h3>

                                <div class="space-y-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" name="name" id="name" required
                                               class="w-full h-12 px-4 rounded-lg border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition duration-200">
                                    </div>

                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                        <input type="email" name="email" id="email" required
                                               class="w-full h-12 px-4 rounded-lg border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition duration-200">
                                    </div>

                                    <div>
                                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="text" name="phone" id="phone" required
                                               class="w-full h-12 px-4 rounded-lg border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition duration-200">
                                    </div>

                                    <div class="form-group">
                                        <label for="lecturer_id">Lecturer ID</label>
                                        <input type="text" name="lecturer_id" id="lecturer_id"
                                            class="form-control @error('lecturer_id') is-invalid @enderror" value="{{ old('lecturer_id') }}" required>
                                        @error('lecturer_id')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="space-y-6">
                            <div class="bg-teal-50 p-6 rounded-xl">
                                <h3 class="text-xl font-semibold text-teal-700 border-b-2 border-teal-200 pb-3 mb-6">Academic Information</h3>

                                <div class="space-y-6">
                                    <div>
                                        <label for="faculty" class="block text-sm font-medium text-gray-700 mb-2">Faculty</label>
                                        <select name="faculty_id" id="faculty" required
                                                class="w-full h-12 px-4 rounded-lg border-2 border-teal-200 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200 focus:ring-opacity-50 transition duration-200">
                                            <option value="">Select Faculty</option>
                                            @foreach($faculties as $faculty)
                                                <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>

                                        <label class="block text-sm font-medium text-gray-700 mb-2">Courses (Select Multiple)</label>
                                        <div class="bg-white p-4 rounded-lg border-2 border-teal-200 max-h-64 overflow-y-auto">
                                            <div class="space-y-2">
                                                @foreach($courses as $course)
                                                <label class="flex items-center p-2 hover:bg-teal-50 rounded-lg cursor-pointer group transition-colors duration-150">
                                                    <input type="checkbox"
                                                           name="course_ids[]"
                                                           value="{{ $course->id }}"
                                                           class="h-5 w-5 text-teal-600 rounded border-gray-300 focus:ring-teal-500">
                                                    <span class="ml-3 text-gray-700 group-hover:text-teal-600 transition-colors duration-150">
                                                        {{ $course->course_name }}
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>

                                        <p class="mt-2 text-sm text-gray-500">Select all applicable courses</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-8">
                        <button type="submit"
                                class="px-8 py-4 bg-teal-600 text-white text-lg font-semibold rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transform hover:-translate-y-0.5 transition duration-200 shadow-lg">
                            Create Lecturer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
