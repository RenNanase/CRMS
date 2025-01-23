@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Timetable</title>
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
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('student.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all duration-300 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
            <a href="{{ route('student.timetable.export') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Export Timetable
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">


            <!-- Header -->
            <div class="bg-teal-600 text-white px-6 py-4">
                <h1 class="text-2xl font-bold">Student Timetable</h1>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-b border-teal-200">
                <p class="text-gray-600 text-center italic">
                    "Dreams without deadlines are just wishes. Start acting on them or someone else will live your dream instead"
                </p>
            </div>


            <!-- legend-->
            <div class="px-6 py-2 bg-gray-50 border-b border-teal-200">
                <div class="flex space-x-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-teal-100 rounded mr-2"></div>
                        <span class="text-sm text-gray-600">Major Courses</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-100 rounded mr-2"></div>
                        <span class="text-sm text-gray-600">Minor Courses</span>
                    </div>
                </div>
            </div>


            @if($timetables->isEmpty())
                <div class="p-8 text-center text-gray-500">
                    <p class="text-lg">No courses enrolled.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-teal-50 border-b border-teal-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-teal-700 uppercase sticky left-0 bg-teal-50 z-20">Day</th>
                                @for ($hour = 7; $hour <= 19; $hour++)
                                    <th class="px-3 py-3 text-center text-xs font-medium text-teal-700 uppercase">
                                        {{ sprintf('%02d:00 - %02d:30', $hour, $hour) }}
                                    </th>
                                    <th class="px-3 py-3 text-center text-xs font-medium text-teal-700 uppercase">
                                        {{ sprintf('%02d:30 - %02d:00', $hour, $hour + 1) }}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-teal-200">
@foreach ($days as $day)
                            <tr class="hover:bg-teal-50 transition duration-200">
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-20">
                                    {{ $day }}
                                </td>
                                @for ($hour = 7; $hour <= 19; $hour++) @php $timeSlot1=sprintf('%02d:00', $hour); $timeSlot2=sprintf('%02d:30',
                                    $hour);
                                @endphp

                                        <!-- Replace the course display section with this -->
<td class="px-2 py-2 border-r border-teal-100 min-w-[120px]">
    @foreach ($timetables as $timetable)
        @if ($timetable->day_of_week == $day &&
            Carbon::parse($timetable->start_time)->format('H:i') <= $timeSlot1 &&
            Carbon::parse($timetable->end_time)->format('H:i') > $timeSlot1)
            <div class="@if($timetable->source === 'minor')
                        bg-indigo-100 hover:bg-indigo-200
                    @else
                        bg-teal-100 hover:bg-teal-200
                    @endif
                    p-2 rounded text-sm group relative transition-colors">

                <div class="font-medium @if($timetable->source === 'minor') text-indigo-700 @else text-teal-700 @endif">
                    {{ $timetable->course_name }}
                    <span class="text-xs ml-1">
                        (@if($timetable->source === 'minor')Minor @else Major @endif)
                    </span>
                </div>

                <!-- Show group only for major courses -->
                @if($timetable->source === 'major' && isset($timetable->group_name))
                <div class="text-teal-600 text-xs font-medium">
                    Group {{ $timetable->group_name }}
                </div>
                @endif

                <div class="@if($timetable->source === 'minor') text-indigo-600 @else text-teal-600 @endif text-xs">
                    {{ $timetable->place }}
                </div>

                <!-- Tooltip with more details -->
                <div class="hidden group-hover:block absolute z-30 left-full top-0 ml-2 w-48 bg-white p-2 rounded-md shadow-lg border border-gray-200">
                    <p class="font-medium @if($timetable->source === 'minor') text-indigo-700 @else text-teal-700 @endif">
                        {{ $timetable->course_name }}
                    </p>
                    <p class="text-gray-600">{{ $timetable->course_code }}</p>
                    @if($timetable->source === 'major' && isset($timetable->group_name))
                    <p class="text-teal-600 font-medium">
                        Group {{ $timetable->group_name }}
                    </p>
                    @endif
                    <p class="@if($timetable->source === 'minor') text-indigo-600 @else text-teal-600 @endif">
                        {{ $timetable->place }}
                    </p>
                    <p class="text-gray-600">
                        {{ Carbon::parse($timetable->start_time)->format('H:i') }} -
                        {{ Carbon::parse($timetable->end_time)->format('H:i') }}
                    </p>
                </div>
            </div>
        @endif
    @endforeach
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
                    </body>

                    </html>
