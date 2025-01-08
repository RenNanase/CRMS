@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Navigation Buttons -->
            <div class="flex space-x-4 mb-4">
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Dashboard
                </a>
                <button onclick="window.history.back()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back
                </button>
            </div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Academic Periods</h2>
        <a href="{{ route('admin.academic-periods.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded-lg">
            Add New Period
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Academic Year
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Semester
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Period
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($academicPeriods as $period)
                <tr>
                    <td class="px-6 py-4">{{ $period->academic_year }}</td>
                    <td class="px-6 py-4">{{ $period->semester }}</td>
                    <td class="px-6 py-4">
                        {{ $period->start_date->format('d/m/Y') }} -
                        {{ $period->end_date->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="px-2 py-1 text-xs rounded-full
                            {{ $period->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($period->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.academic-periods.edit', $period) }}"
                            class="text-teal-600 hover:text-teal-900">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $academicPeriods->links() }}
    </div>
</div>
@endsection
