@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h3 class="text-3xl font-bold text-teal-700">
            {{ $course->course_name }} ({{ $course->course_code }})
        </h3>
    </div>

    <!-- Student List Section -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="p-6">
            @if($enrolledStudents->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-teal-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase">Matric No</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase">Name</th>
                            <th class="px-4 py-3 text-left text-sm font-medium uppercase">Program</th>
                            <th class="px-4 py-3 text-center text-sm font-medium uppercase">Group</th>
                            <th class="px-4 py-3 text-center text-sm font-medium uppercase">Schedule</th>
                            <th class="px-4 py-3 text-center text-sm font-medium uppercase">Place</th>
                            <th class="px-4 py-3 text-center text-sm font-medium uppercase">Type</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($enrolledStudents as $enrollment)
                        <tr class="hover:bg-teal-50 transition">
                            <td class="px-4 py-3 text-gray-800 text-sm">{{ $enrollment['matric_number'] }}</td>
                            <td class="px-4 py-3 text-gray-800 text-sm">{{ $enrollment['student']->name }}</td>
                            <td class="px-4 py-3 text-gray-800 text-sm">{{ $enrollment['student']->program->name ??
                                'N/A' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $enrollment['group_name'] ?? 'Not Assigned' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-800 text-sm">
                                @if($enrollment['day_of_week'] && $enrollment['time'])
                                {{ $enrollment['day_of_week'] }} {{
                                \Carbon\Carbon::parse($enrollment['time'])->format('h:i A') }}
                                @else
                                Not Scheduled
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-gray-800 text-sm">
                                {{ $enrollment['place'] ?? 'TBA' }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $enrollment['request_type'] === 'major' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($enrollment['request_type']) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-10">
                <p class="text-teal-500 text-lg">No students enrolled in this course yet.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Navigation Button -->
    <div class="mt-6">
        <a href="{{ route('lecturer.courses') }}"
            class="inline-flex items-center px-5 py-2 bg-teal-100 text-teal-600 font-medium rounded-lg hover:bg-teal-200 transition">
            <i class="fas fa-arrow-left mr-2"></i> Back to Courses
        </a>
    </div>
</div>
@endsection
