<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Registration Period</title>
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
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a'
                        }
                    }
                }
            }
        }
    </script>
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

        .form-input-modern {
            @apply w-full rounded-lg border-2 border-teal-200 bg-white/70 px-4 py-2.5 focus: border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-200;
        }
    </style>
</head>

<body class="min-h-screen py-8 px-4 bg-gradient-to-br from-teal-50 to-teal-100/50">
    <div class="container mx-auto max-w-5xl">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-8">
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
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 mr-2 transition-transform group-hover:-translate-x-1" viewBox="0 0 20 20"
                    fill="currentColor">
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

        <div class="glass-card rounded-xl overflow-hidden shadow-xl">
            <!-- Header Section with enhanced padding -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-500 text-white px-10 py-8">
                <h2 class="text-3xl font-bold">Create Registration Period</h2>
                <p class="text-teal-100 mt-2 text-lg">Set up a new registration period for students</p>
            </div>

            <!-- Form Section with improved spacing -->
            <div class="p-10 space-y-8 bg-white/80">
                <form action="{{ route('admin.registration-periods.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 gap-8">
                        <!-- Academic Period Section -->
                        <div class="bg-teal-50/50 rounded-xl p-6 space-y-4 border border-teal-100">
                            <h3 class="text-lg font-semibold text-teal-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 4h-1V3a1 1 0 00-2 0v1H8V3a1 1 0 00-2 0v1H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                </svg>
                                Academic Period Details
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Academic Period -->
                                <div class="space-y-2">
                                    <label for="academic_period_id" class="block text-sm font-medium text-teal-800">
                                        Academic Period
                                    </label>
                                    <select id="academic_period_id" name="academic_period_id" required
                                        class="form-input-modern h-12">
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
                                    <label for="type" class="block text-sm font-medium text-teal-800">
                                        Registration Type
                                    </label>
                                    <select id="type" name="type" required
                                        class="form-input-modern h-12">
                                        <option value="">Select Type</option>
                                        <option value="major">Major Course</option>
                                        <option value="minor">Minor Course</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range Section -->
                        <div class="bg-teal-50/50 rounded-xl p-6 space-y-4 border border-teal-100">
                            <h3 class="text-lg font-semibold text-teal-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Registration Period Duration
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Start Date -->
                                <div class="space-y-2">
                                    <label for="start_date" class="block text-sm font-medium text-teal-800">
                                        Start Date & Time
                                    </label>
                                    <input type="datetime-local" id="start_date" name="start_date" required
                                        class="form-input-modern h-12">
                                </div>

                                <!-- End Date -->
                                <div class="space-y-2">
                                    <label for="end_date" class="block text-sm font-medium text-teal-800">
                                        End Date & Time
                                    </label>
                                    <input type="datetime-local" id="end_date" name="end_date" required
                                        class="form-input-modern h-12">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button Section -->
                    <div class="pt-8 mt-8 border-t border-teal-100">
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="window.history.back()"
                                class="px-6 py-3 bg-white border-2 border-teal-200 text-teal-700 rounded-xl hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-xl hover:from-teal-700 hover:to-teal-600 transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5 inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Create Period
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
