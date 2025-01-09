@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Registration Periods</h1>
                <p class="text-gray-600 mt-1">Manage registration periods for students</p>
            </div>
            <a href="{{ route('admin.registration-periods.create') }}"
                class="mt-4 md:mt-0 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Period
                </span>
            </a>
        </div>

        <!-- Filters Section -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <form action="{{ route('admin.registration-periods.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic
                        Year</label>
                    <select name="academic_year" id="academic_year"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">All Years</option>
                        @foreach($academicPeriods as $period)
                        <option value="{{ $period->academic_year }}" {{ request('academic_year')==$period->academic_year
                            ? 'selected' : '' }}>
                            {{ $period->academic_year }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Registration Type</label>
                    <select name="type" id="type"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">All Types</option>
                        <option value="major" {{ request('type')=='major' ? 'selected' : '' }}>Major Course</option>
                        <option value="minor" {{ request('type')=='minor' ? 'selected' : '' }}>Minor Course</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-md shadow-sm transition">
                        Filter Results
                    </button>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Academic Period
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Start Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            End Date
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($registrationPeriods as $period)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $period->academicPeriod->academic_year ?? 'N/A' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                Semester {{ $period->academicPeriod->semester ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $period->type === 'major' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ ucfirst($period->type ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $period->start_date ? $period->start_date->format('M d, Y H:i') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $period->end_date ? $period->end_date->format('M d, Y H:i') : 'N/A' }}
                        </td>
<td class="px-6 py-4 whitespace-nowrap">
    @php
    $statusClass = match($period->status) {
    'active' => 'bg-green-100 text-green-800',
    'closed' => 'bg-red-100 text-red-800',
    'upcoming' => 'bg-yellow-100 text-yellow-800',
    default => 'bg-gray-100 text-gray-800'
    };
    @endphp
    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
        {{ ucfirst($period->status) }}
    </span>
</td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.registration-periods.edit', $period) }}"
                                    class="text-teal-600 hover:text-teal-900">Edit</a>
                                <form action="{{ route('admin.registration-periods.destroy', $period) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this registration period?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No registration periods found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($registrationPeriods->hasPages())
        <div class="mt-4">
            {{ $registrationPeriods->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
