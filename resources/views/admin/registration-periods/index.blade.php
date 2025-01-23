<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Periods Management</title>
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
            @apply w-full rounded-lg border-2 border-teal-200 bg-white/70 px-4 py-2.5 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-200;
        }
        .btn-primary {
            @apply px-4 py-2.5 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:-translate-y-0.5;
        }
        .btn-secondary {
            @apply px-4 py-2.5 bg-white text-teal-700 border-2 border-teal-200 rounded-lg hover:bg-teal-50 hover:border-teal-300 transition-all duration-200;
        }
        .alert {
            @apply p-4 rounded-lg shadow-lg mb-6 border-l-4;
        }
        .alert-success {
            @apply bg-green-50 border-green-500 text-green-700;
        }
    </style>
</head>

<body class="min-h-screen py-8 px-4">
    <div class="container mx-auto max-w-7xl">
        <!-- Navigation Buttons with enhanced design -->
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('admin.dashboard') }}"
               class="group inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-xl hover:from-teal-700 hover:to-teal-600 transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                <span class="relative">
                    Dashboard
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </span>
            </a>
            <button onclick="window.history.back()"
                    class="group inline-flex items-center px-5 py-2.5 bg-white border-2 border-teal-200 text-teal-700 rounded-xl hover:bg-teal-50 hover:border-teal-300 transition-all duration-200 shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform group-hover:-translate-x-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                <span class="relative">
                    Back
                    <span class="absolute inset-x-0 bottom-0 h-0.5 bg-teal-600 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span>
                </span>
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="glass-card rounded-xl overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-teal-600 to-teal-500 text-white px-8 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold">Registration Periods Management</h2>

                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.registration-periods.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg transition-all duration-200 border border-white/20 backdrop-blur-sm">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add New Period
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Filter Section -->
            <div class="bg-gradient-to-b from-teal-50/50 to-white/50 p-8 border-b border-teal-100 rounded-t-xl">
                <form action="{{ route('admin.registration-periods.index') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Academic Year Filter -->
                        <div class="md:col-span-4 relative group">
                            <label for="academic_year" class="block text-sm font-medium text-teal-800 mb-2 group-hover:text-teal-600 transition-colors">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4h-1V3a1 1 0 00-2 0v1H8V3a1 1 0 00-2 0v1H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V6a2 2 0 00-2-2z" />
                                    </svg>
                                    Academic Year
                                </span>
                            </label>
                            <select name="academic_year" id="academic_year"
                                class="w-full rounded-xl border-2 border-teal-200 bg-white/70 px-4 py-3 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-200 hover:border-teal-300">
                                <option value="">All Academic Years</option>
                                @foreach($academicPeriods as $period)
                                <option value="{{ $period->academic_year }}" {{ request('academic_year') == $period->academic_year ? 'selected' : '' }}>
                                    {{ $period->academic_year }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Registration Type Filter -->
                        <div class="md:col-span-4 relative group">
                            <label for="type" class="block text-sm font-medium text-teal-800 mb-2 group-hover:text-teal-600 transition-colors">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Registration Type
                                </span>
                            </label>
                            <select name="type" id="type"
                                class="w-full rounded-xl border-2 border-teal-200 bg-white/70 px-4 py-3 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/30 transition-all duration-200 hover:border-teal-300">
                                <option value="">All Types</option>
                                <option value="major" {{ request('type') == 'major' ? 'selected' : '' }}>Major Course</option>
                                <option value="minor" {{ request('type') == 'minor' ? 'selected' : '' }}>Minor Course</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="md:col-span-4 flex items-end">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-xl hover:from-teal-700 hover:to-teal-600 transition-all duration-200 shadow-md hover:shadow-xl hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                                <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-teal-50 border-b border-teal-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Academic Period</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Start Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                End Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-teal-200">
                        @forelse($registrationPeriods as $period)
                        <tr class="hover:bg-teal-50 transition duration-150">
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $period->academicPeriod->academic_year ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    Semester {{ $period->academicPeriod->semester ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $period->type === 'major' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($period->type ?? 'N/A') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $period->start_date ? $period->start_date->format('M d, Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $period->end_date ? $period->end_date->format('M d, Y H:i') : 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                @php
                                $statusClass = match($period->status) {
                                'active' => 'bg-green-100 text-green-800',
                                'closed' => 'bg-red-100 text-red-800',
                                'upcoming' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800'
                                };
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($period->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('admin.registration-periods.edit', $period) }}"
                                        class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-1 rounded text-xs font-medium transition duration-150">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.registration-periods.destroy', $period) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this registration period?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs font-medium transition duration-150">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-3 text-sm text-gray-500 text-center">
                                No registration periods found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($registrationPeriods->hasPages())
            <div class="bg-gradient-to-t from-teal-50/50 to-white/50 px-6 py-4 border-t border-teal-100">
                {{ $registrationPeriods->links() }}
            </div>
            @endif
        </div>
    </div>
</body>

</html>
