<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Management</title>
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
    <style>
        .alert {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .course-container {
            max-height: 80px;
            overflow-y: auto;
            scrollbar-width: thin;
        }
        .course-container::-webkit-scrollbar {
            width: 6px;
        }
        .course-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .course-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
        .course-tag {
            display: inline-block;
            margin: 2px;
            padding: 2px 8px;
            background-color: #99f6e4;
            color: #0f766e;
            border-radius: 12px;
            font-size: 0.75rem;
            white-space: nowrap;
        }
    </style>
</head>

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

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Lecturer Management</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.lecturers.create') }}" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Add New Lecturer
                    </a>
                    <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Export
                    </button>
                </div>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-teal-50 border-b border-teal-200">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Faculty</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider w-1/5">Courses</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-teal-200">
                        @foreach($lecturers as $lecturer)
                        <tr class="hover:bg-teal-50 transition duration-150">
                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $lecturer->name }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $lecturer->email }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $lecturer->phone }}</td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $lecturer->faculty->faculty_name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="course-container">
                                    @if($lecturer->courses->isNotEmpty())
                                        @foreach($lecturer->courses as $course)
                                            <span class="course-tag">{{ $course->course_name }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-gray-500">No courses assigned</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.lecturers.edit', $lecturer->id) }}"
                                       class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-1 rounded text-xs font-medium transition duration-150">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.lecturers.destroy', $lecturer->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition duration-150">
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
            <div class="bg-teal-50 px-4 py-3 border-t border-teal-200 flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">50</span> results
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition duration-150">
                        Previous
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-teal-600 border border-transparent rounded-md hover:bg-teal-700 transition duration-150">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
