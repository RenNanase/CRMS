@extends('layouts.app')

@section('title', 'Minor Registration Applications')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-teal-50 to-gray-50 py-8">
    <div class="container mx-auto max-w-7xl px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-teal-800">Minor Course Applications</h2>
            <div class="flex space-x-4">
                                <a href="{{ route('dean.dashboard') }}"
                                    class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    Dashboard
                                </a>


            </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mb-6 transform transition-all duration-300 hover:scale-[1.02]">
            <div class="flex items-center p-4 bg-teal-100 border-l-4 border-teal-500 rounded-r-lg">
                <svg class="w-6 h-6 text-teal-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-teal-700">{{ session('success') }}</span>
            </div>
        </div>
        @endif

        <!-- Applications Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-teal-100">


            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-teal-100">
                    <thead class="bg-teal-50">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Student Name
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Matric Number
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Minor Course
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Submission Date
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-teal-100">
                        @forelse($minorRegistrations as $registration)
                        <tr class="hover:bg-teal-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                {{ $registration->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                {{ $registration->matric_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                <span class="font-medium">{{ $registration->course_code }}</span>
                                <span class="text-gray-500">- {{ $registration->course_name }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                @if($registration->status === 'pending')
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 text-center">
                                    Pending
                                </span>
                                @elseif($registration->status === 'approved')
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-teal-100 text-teal-800 text-center">
                                    Approved
                                </span>
                                @else
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 text-center">
                                    Rejected
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                {{ $registration->created_at->format('d/m/Y') }}
                            </td>
<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
    @if($registration->status === 'pending')
    <div class="flex justify-center">
        <a href="{{ route('dean.minor-requests.review', $registration->id) }}" class="inline-flex items-center px-3 py-1.5 bg-teal-600 text-white text-sm rounded-lg
                  hover:bg-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Review
        </a>
                                </div>
                                @else
                                <span class="text-sm text-gray-500 italic text-center">
                                    Processed by {{ $registration->dean_name ?? 'Dean' }}
                                    @if($registration->recommendation_date)
                                    on {{ \Carbon\Carbon::parse($registration->recommendation_date)->format('d/m/Y') }}
                                    @endif
                                </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-teal-200 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="font-medium">No minor registration applications found</span>
                                    <p class="text-sm mt-1">New applications will appear here</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($minorRegistrations->hasPages())
            <div class="px-6 py-4 border-t border-teal-100 bg-teal-50">
                {{ $minorRegistrations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .pagination {
        @apply flex justify-center space-x-1;
    }

    .pagination>* {
        @apply px-3 py-1 text-sm rounded-md;
    }

    .pagination>.active {
        @apply bg-teal-600 text-white;
    }

    .pagination>*:not(.active) {
        @apply text-teal-600 hover: bg-teal-100;
    }
</style>
@endsection
