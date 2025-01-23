<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Student Enrollment Status</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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

        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('student.dashboard') }}"
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

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Major Enrollment Status</h2>
                <div class="flex space-x-2">
                    <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded">
                        Export
                    </button>

                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">


                    <thead class="bg-teal-50 border-b border-teal-200">
                        <tr>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Course Code</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Course Name</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Request Type</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Submission Date</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-teal-200">
                        @forelse ($courseRequests as $request)
                            <tr class="hover:bg-teal-50 transition duration-200">
                                <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $request->course->course_code }}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $request->course->course_name }}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $request->request_type }}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $request->created_at->format('Y-m-d') }}</td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    @switch($request->status)
                                        @case('approved')
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Approved
                                            </span>
                                            @break
                                        @case('rejected')
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                            @break
                                        @default
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $request->remarks ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500">No enrollment requests found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
<!-- Pagination -->
@if(isset($courseRequests) && $courseRequests->hasPages())
    <div class="bg-teal-50 px-4 py-3 border-t border-teal-200 flex justify-between items-center">
        <div class="text-sm text-gray-700">
            Showing {{ $courseRequests->firstItem() }} to {{ $courseRequests->lastItem() }} of {{ $courseRequests->total() }} results
        </div>
        <div class="flex space-x-2">
            {{ $courseRequests->links() }}
        </div>
    </div>
@endif
        </div>


<!-- Minor Enrollment Status -->
<div class="bg-white shadow-md rounded-lg overflow-hidden mt-8">
    <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
        <h2 class="text-2xl font-bold">Minor Enrollment Status</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-teal-50 border-b border-teal-200">
                <tr>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Course
                        Code</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Course
                        Name</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Proposed
                        Semester</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                        Submission Date</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Status
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Dean's
                        Comments</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-teal-200">
                @forelse ($minorRegistrations as $registration)
                <tr class="hover:bg-teal-50 transition duration-200">
                    <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $registration->course_code }}</td>
                    <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $registration->course_name }}</td>
                    <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $registration->proposed_semester }}
                    </td>
                    <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{
                        $registration->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $registration->status === 'approved' ? 'bg-green-100 text-green-800' :
                               ($registration->status === 'rejected' ? 'bg-red-100 text-red-800' :
                               ($registration->status === 'cancelled' ? 'bg-gray-100 text-gray-800' : 'bg-yellow-100 text-yellow-800')) }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center whitespace-nowrap text-sm text-gray-700">{{ $registration->dean_comments ?? '-'
                        }}</td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        <!-- Debug information -->
                        <div class="text-xs text-gray-500">
                            Status: {{ $registration->status }}
                        </div>

                        @if($registration->status === 'pending')
                            <form action="{{ route('student.minor-registration.cancel', $registration) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Are you sure you want to cancel this application?')"
                                        class="text-yellow-600 hover:text-yellow-800 font-medium text-sm mr-2">
                                    Cancel
                                </button>
                            </form>
                        @endif

                        @if(in_array($registration->status, ['rejected', 'cancelled']))
                            <form action="{{ route('student.minor-registration.destroy', $registration) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Warning: This action cannot be undone. Are you sure you want to delete this application?')"
                                        class="text-red-600 hover:text-red-800 font-medium text-sm">
                                    Delete
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500">No minor registration applications found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($minorRegistrations) && $minorRegistrations->hasPages())
    <div class="bg-teal-50 px-4 py-3 border-t border-teal-200 flex justify-between items-center">
        <div class="text-sm text-gray-700">
            Showing {{ $minorRegistrations->firstItem() }} to {{ $minorRegistrations->lastItem() }} of {{
            $minorRegistrations->total() }} results
        </div>
        <div class="flex space-x-2">
            {{ $minorRegistrations->links() }}
        </div>
    </div>
    @endif
</div>


    </div>
</body>
</html>
