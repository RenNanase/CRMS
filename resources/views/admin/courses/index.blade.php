<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Management</title>
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
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">

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

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Courses Management</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('courses.create') }}" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Add New Course
                    </a>
                    <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Export
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="p-4 bg-teal-50 border-b border-teal-200">
                <form action="{{ route('courses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-teal-700">Course Name</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label for="faculty" class="block text-sm font-medium text-teal-700">Faculty</label>
                        <select name="faculty" id="faculty"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Faculties</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->id }}" {{ request('faculty') == $faculty->id ? 'selected' : '' }}>
                                    {{ $faculty->faculty_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="course_code" class="block text-sm font-medium text-teal-700">Course Code</label>
                        <input type="text" name="course_code" id="course_code" value="{{ request('course_code') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-teal-700">Type</label>
                        <select name="type" id="type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Types</option>
                            <option value="major" {{ request('type') == 'major' ? 'selected' : '' }}>Major</option>
                            <option value="minor" {{ request('type') == 'minor' ? 'selected' : '' }}>Minor</option>
                        </select>
                    </div>
                    <div class="md:col-span-4 flex justify-end space-x-2">
                        <button type="submit"
                                class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md transition duration-150">
                            Apply Filters
                        </button>
                        <a href="{{ route('courses.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-150">
                            Clear Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Course Details Display (if available) -->
            @if(session('course'))
                <div class="bg-teal-50 p-6 border-b border-teal-200">
                    <h2 class="text-lg font-semibold text-teal-700 mb-3">Course Details</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <p><span class="font-medium">Name:</span> {{ session('course')->course_name }}</p>
                        <p><span class="font-medium">Code:</span> {{ session('course')->course_code }}</p>
                        <p><span class="font-medium">Credit Hours:</span> {{ session('course')->credit_hours }}</p>
                        <p><span class="font-medium">Faculty:</span> {{ session('course')->faculty ? session('course')->faculty->faculty_name : 'No Faculty Assigned' }}</p>
                    </div>
                    @if(count(session('course')->prerequisites) > 0)
                        <div class="mt-3">
                            <h3 class="font-medium text-teal-700">Prerequisites:</h3>
                            <ul class="list-disc list-inside">
                                @foreach(session('course')->prerequisites as $prerequisite)
                                    <li class="text-gray-700">{{ $prerequisite->course_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-teal-50 border-b border-teal-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Course Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Course Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Credit Hours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Faculty</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-teal-200">
                        @foreach($courses as $course)
                            <tr class="hover:bg-teal-50 transition duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->course_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->course_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->credit_hours }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $course->faculty ? $course->faculty->faculty_name : 'No Faculty Assigned' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $course->type === 'core' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($course->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('courses.edit', $course->id) }}"
                                           class="bg-teal-100 text-teal-700 hover:bg-teal-200 px-3 py-1 rounded-md text-sm transition duration-150">
                                            Edit
                                        </a>
                                        <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-md text-sm transition duration-150">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Section -->
            <div class="bg-teal-50 px-6 py-4 border-t border-teal-200">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                    <div class="text-sm text-gray-700">
                        Showing {{ ($courses->currentPage() - 1) * $courses->perPage() + 1 }}
                        to {{ $courses->lastItem() }}
                        of {{ $courses->total() }} courses
                    </div>
                    <div>
                        @if ($courses->hasPages())
                            <nav class="relative z-0 inline-flex space-x-1">
                                {{-- Previous Page Link --}}
                                @if ($courses->onFirstPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $courses->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Previous
                                    </a>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($courses->getUrlRange(1, $courses->lastPage()) as $page => $url)
                                    @if ($page == $courses->currentPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-teal-600 cursor-default rounded-md">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($courses->hasMorePages())
                                    <a href="{{ $courses->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                        Next
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                        Next
                                    </span>
                                @endif
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
