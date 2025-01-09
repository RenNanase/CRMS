<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timetable Management</title>
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
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">Timetable Management</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.timetables.index') }}" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Add New Schedule
                    </a>
                    <button class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150">
                        Export
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="p-4 bg-teal-50 border-b border-teal-200">
                <form action="{{ route('admin.timetables.show') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
<div>
                        <label for="course_code" class="block text-sm font-medium text-teal-700">Course Code</label>
                        <select name="course_code" id="course_code"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Courses</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->course_code }}" {{ request('course_code')==$course->course_code ? 'selected' : '' }}>
                                {{ $course->course_code }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="course_type" class="block text-sm font-medium text-teal-700">Course Type</label>
                        <select name="course_type" id="course_type"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            <option value="">All Types</option>
                            <option value="Major">Major</option>
                            <option value="Minor">Minor</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-md transition duration-150">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            @if($timetables->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">No timetables available.</p>
                </div>
            @else
                <!-- Timetable Section -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-teal-50 border-b border-teal-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase sticky left-0 bg-teal-50 z-20">Day</th>
                                @for ($hour = 7; $hour <= 19; $hour++)
                                    <th class="px-3 py-3 text-center text-xs font-medium text-teal-700 uppercase" colspan="2">
                                        {{ sprintf('%02d:00', $hour) }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-teal-200">
                            @foreach ($days as $day)
                                <tr class="hover:bg-teal-50 transition duration-200">
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-20">{{ $day }}</td>
                                    @for ($hour = 7; $hour <= 19; $hour++)
                                        @php
                                            $timeSlot1 = sprintf('%02d:00', $hour);
                                            $timeSlot2 = sprintf('%02d:30', $hour);
                                        @endphp
                                        <td class="px-2 py-2 border-r border-teal-100 min-w-[120px]">
                                            <div class="max-h-32 overflow-y-auto">
                                                @foreach ($timetables as $timetable)
                                                    @if ($timetable->day_of_week == $day && $timetable->start_time <= $timeSlot1 && $timetable->end_time > $timeSlot1)
                                                        <div class="bg-teal-100 p-2 rounded text-xs mb-1 hover:bg-teal-200 transition-colors cursor-pointer group relative">
                                                            <div class="font-medium text-teal-700">{{ $timetable->course_name }}</div>
                                                            <div class="text-teal-600">[{{ $timetable->course_code }}]</div>
                                                            <div class="text-teal-600">{{ $timetable->place }}</div>
                                                            <div class="text-teal-600">{{ $timetable->lecturer->name }}</div>

                                                            <!-- Tooltip -->
                                                            <div class="hidden group-hover:block absolute z-30 left-full top-0 ml-2 w-64 bg-white p-3 rounded-md shadow-lg border border-teal-200">
                                                                <div class="space-y-2">
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Course</p>
                                                                        <p class="text-gray-600">{{ $timetable->course_name }} [{{ $timetable->course_code }}]</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Lecturer</p>
                                                                        <p class="text-gray-600">{{ $timetable->lecturer->name }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Location</p>
                                                                        <p class="text-gray-600">{{ $timetable->place }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Time</p>
                                                                        <p class="text-gray-600">{{ $timetable->start_time }} - {{ $timetable->end_time }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 border-r border-teal-100 min-w-[120px]">
                                            <div class="max-h-32 overflow-y-auto">
                                                @foreach ($timetables as $timetable)
                                                    @if ($timetable->day_of_week == $day && $timetable->start_time <= $timeSlot2 && $timetable->end_time > $timeSlot2)
                                                        <div class="bg-teal-100 p-2 rounded text-xs mb-1 hover:bg-teal-200 transition-colors cursor-pointer group relative">
                                                            <div class="font-medium text-teal-700">{{ $timetable->course_name }}</div>
                                                            <div class="text-teal-600">[{{ $timetable->course_code }}]</div>
                                                            <div class="text-teal-600">{{ $timetable->place }}</div>
                                                            <div class="text-teal-600">{{ $timetable->lecturer->name }}</div>

                                                            <!-- Tooltip -->
                                                            <div class="hidden group-hover:block absolute z-30 left-full top-0 ml-2 w-64 bg-white p-3 rounded-md shadow-lg border border-teal-200">
                                                                <div class="space-y-2">
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Course</p>
                                                                        <p class="text-gray-600">{{ $timetable->course_name }} [{{ $timetable->course_code }}]</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Lecturer</p>
                                                                        <p class="text-gray-600">{{ $timetable->lecturer->name }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Location</p>
                                                                        <p class="text-gray-600">{{ $timetable->place }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <p class="font-medium text-teal-700">Time</p>
                                                                        <p class="text-gray-600">{{ $timetable->start_time }} - {{ $timetable->end_time }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <script>
        document.getElementById('course_code').addEventListener('change', function() {
            const selectedCourse = this.value;
            const currentUrl = new URL(window.location.href);

            if (selectedCourse) {
                currentUrl.searchParams.set('course_code', selectedCourse);
            } else {
                currentUrl.searchParams.delete('course_code');
            }

            window.location.href = currentUrl.toString();
        });
    </script>
</body>
</html>
