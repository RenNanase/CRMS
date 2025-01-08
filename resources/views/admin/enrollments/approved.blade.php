<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Enrollments Management</title>
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
        .alert-approve {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-reject {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-teal-50 to-teal-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

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

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-teal-100 mr-4">
                        <i class="fas fa-user-graduate text-teal-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Approved</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $approvedEnrollments->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-teal-100 mr-4">
                        <i class="fas fa-clock text-teal-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">This Month</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $approvedEnrollments->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-teal-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-teal-100 mr-4">
                        <i class="fas fa-chart-line text-teal-500 text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Approval Rate</p>
                        <p class="text-2xl font-bold text-gray-800">95%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-teal-600 p-6">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-white">Approved Enrollments</h1>
                    <div class="flex space-x-2">
                        <button class="bg-white text-teal-600 px-4 py-2 rounded-md hover:bg-teal-50 transition duration-150 flex items-center">
                            <i class="fas fa-download mr-2"></i> Export
                        </button>
                        <button class="bg-white text-teal-600 px-4 py-2 rounded-md hover:bg-teal-50 transition duration-150 flex items-center">
                            <i class="fas fa-print mr-2"></i> Print
                        </button>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 m-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-teal-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-teal-100">
                        @foreach($approvedEnrollments as $enrollment)
                            <tr class="hover:bg-teal-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    #{{ $enrollment->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-teal-100 flex items-center justify-center">
                                            <span class="text-teal-600 font-medium">{{ substr($enrollment->student_name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $enrollment->student_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $enrollment->student_email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $enrollment->course_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $enrollment->course_code ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $enrollment->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($enrollment->created_at)->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <button class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.enrollments.reject', $enrollment->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to reject this enrollment?')">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-teal-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1 flex justify-between sm:hidden">
                        {{ $approvedEnrollments->links() }}
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Showing
                                <span class="font-medium">{{ $approvedEnrollments->firstItem() }}</span>
                                to
                                <span class="font-medium">{{ $approvedEnrollments->lastItem() }}</span>
                                of
                                <span class="font-medium">{{ $approvedEnrollments->total() }}</span>
                                results
                            </p>
                        </div>
                        <div>
                            {{ $approvedEnrollments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>