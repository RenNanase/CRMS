@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Create Registration Period</h1>
            <p class="text-gray-600">Set up a new registration period for students</p>
        </div>

        <form action="{{ route('admin.registration-periods.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <!-- Academic Period -->
                <div class="space-y-2">
                    <label for="academic_period_id" class="block text-sm font-medium text-gray-700">
                        Academic Period
                    </label>
                    <select id="academic_period_id" name="academic_period_id" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Select Academic Period</option>
                        @foreach($academicPeriods as $period)
                        <option value="{{ $period->id }}">
                            {{ $period->academic_year }} - Semester {{ $period->semester }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Registration Type -->
                <div class="space-y-2">
                    <label for="type" class="block text-sm font-medium text-gray-700">
                        Registration Type
                    </label>
                    <select id="type" name="type" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="">Select Type</option>
                        <option value="major">Major Course</option>
                        <option value="minor">Minor Course</option>
                    </select>
                </div>

                <!-- Date Range Container -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Start Date -->
                    <div class="space-y-2">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">
                            Start Date
                        </label>
                        <input type="datetime-local" id="start_date" name="start_date" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <!-- End Date -->
                    <div class="space-y-2">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">
                            End Date
                        </label>
                        <input type="datetime-local" id="end_date" name="end_date" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="w-full md:w-auto px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-md shadow-sm transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Create Registration Period
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
