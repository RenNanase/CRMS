<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
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

<!-- Success Message -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

<!-- Error Message -->
@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
</div>
@endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Student Management</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.students.create') }}" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Add New Student
                        @csrf
                    </a>
                    <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Export
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-teal-50 p-4 border-b border-teal-200">
                <form action="{{ route('admin.students.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-teal-700 mb-1">Name</label>
                        <input type="text" id="name" name="name"
                               value="{{ request('name') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label for="matric_number" class="block text-sm font-medium text-teal-700 mb-1">Matric Number</label>
                        <input type="text" id="matric_number" name="matric_number"
                               value="{{ request('matric_number') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    <div>
                        <label for="programme" class="block text-sm font-medium text-teal-700 mb-1">Programme</label>
                        <select id="programme" name="programme"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Programmes</option>
                            <option value="Computer Science" {{ request('programme') == 'Computer Science' ? 'selected' : '' }}>AC10</option>
                            <option value="Engineering" {{ request('programme') == 'Engineering' ? 'selected' : '' }}>AT54</option>
                            <option value="Business" {{ request('programme') == 'Business' ? 'selected' : '' }}>AT20</option>
                        </select>
                    </div>
                    <div>
                        <label for="scholarship_status" class="block text-sm font-medium text-teal-700 mb-1">Scholarship Status</label>
                        <select id="scholarship_status" name="scholarship_status"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Status</option>
                            <option value="1" {{ request('scholarship_status') == '1' ? 'selected' : '' }}>Scholarship</option>
                            <option value="0" {{ request('scholarship_status') == '0' ? 'selected' : '' }}>Non-Scholarship</option>
                        </select>
                    </div>
                    <div class="md:col-span-4 flex justify-end space-x-2">
                        <button type="reset"
                                class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-150">
                            Reset
                        </button>
                        <button type="submit"
                                class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700 transition duration-150">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
<table class="w-full">
    <thead class="bg-teal-50 border-b border-teal-200">
        <tr>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Name</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Matric Number
            </th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Phone</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Email</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Faculty</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Program (Code)
            </th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Scholarship
                Status</th>
            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Actions</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-teal-200">
        @foreach($students as $student)
        <tr class="hover:bg-teal-50 transition duration-150">
            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $student->name }}</td>
            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $student->matric_number }}</td>
            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $student->phone }}</td>
            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $student->email }}</td>
            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $student->faculty->faculty_name ?? 'N/A' }}</td>
            <td class="px-4 py-3 text-center text-sm text-gray-700">{{ $student->program->name ?? 'N/A' }} ({{
                $student->program->code ?? 'N/A' }})</td>
            <td class="px-4 py-3 text-center text-sm">
                <span
                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $student->scholarship_status ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ $student->scholarship_status }}
                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.students.create', $student->id) }}"
                                       class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-1 rounded text-xs font-medium transition duration-150">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" style="display:inline;">
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
