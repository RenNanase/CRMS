@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Navigation Buttons with enhanced design -->
    <div class="flex space-x-4 mb-6">
        <a href="{{ route('admin.dashboard') }}"
            class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-xl hover:from-teal-700 hover:to-teal-600 transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform group-hover:scale-110"
                viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
            <span class="relative">
                Dashboard
                <span
                    class="absolute inset-x-0 bottom-0 h-0.5 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            </span>
        </a>
        <button onclick="window.history.back()"
            class="group inline-flex items-center px-5 py-2.5 bg-white border-2 border-teal-200 text-teal-700 rounded-xl hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 shadow-sm hover:shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform group-hover:-translate-x-1"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            <span class="relative">
                Back
                <span
                    class="absolute inset-x-0 bottom-0 h-0.5 bg-teal-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
            </span>
        </button>
    </div>

    <div class="glass-card rounded-xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-teal-600 to-teal-500 text-white px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Academic Periods Management</h2>

                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.academic-periods.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all duration-200 border border-white/20 backdrop-blur-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add New Period
                    </a>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-teal-50 border-b border-teal-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                            Academic Year</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                            Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                            Period</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                            Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-teal-200">
                    @foreach($academicPeriods as $period)
                    <tr class="hover:bg-teal-50 transition duration-150">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $period->academic_year }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">Semester {{ $period->semester }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700">
                                {{ $period->start_date->format('d/m/Y') }} - {{ $period->end_date->format('d/m/Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $period->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($period->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('admin.academic-periods.edit', $period) }}"
                                    class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-1 rounded text-xs font-medium transition duration-150">
                                    Edit
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($academicPeriods->hasPages())
        <div class="bg-gradient-to-t from-teal-50/50 to-white/50 px-6 py-4 border-t border-teal-100">
            {{ $academicPeriods->links('pagination::tailwind') }}
        </div>
        @endif
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #f0fdfa 0%, #ccfbf1 100%);
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
    }
</style>
@endsection
