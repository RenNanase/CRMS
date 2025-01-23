@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Notifications -->
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <!-- Dashboard Button -->
    <div class="flex justify-end mb-6">
        <a href="{{ route('lecturer.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-extrabold text-teal-700 mb-6 ">My Courses</h2>

        @if($courses->isEmpty())
        <div class="text-center py-10">
            <p class="text-gray-500 text-lg">No courses assigned yet.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-teal-600 text-white">
                    <tr>
                        <th class="py-4 px-6 text-left text-sm font-medium">Course Code</th>
                        <th class="py-4 px-6 text-left text-sm font-medium">Course Name</th>
                        <th class="py-4 px-6 text-center text-sm font-medium">Faculty</th>
                        <th class="py-4 px-6 text-center text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($courses as $course)
                    <tr class="hover:bg-teal-50 transition">
                        <td class="py-4 px-6 text-gray-700 text-sm font-[Lato]">{{ $course->course_code }}</td>
                        <td class="py-4 px-6 text-gray-700 text-sm font-[Lato]">{{ $course->course_name }}</td>
                        <td class="py-4 px-6 text-center text-gray-700 text-sm font-[Lato]">{{
                            $course->faculty->faculty_name }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('lecturer.course.students', $course->id) }}"
                                class="bg-teal-500 text-white text-sm font-semibold py-2 px-4 rounded-lg hover:bg-teal-600 transition">
                                <i class="fas fa-users mr-2"></i>View Students
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
