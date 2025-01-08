<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="dashboard-header d-flex justify-content-between align-items-center">
                </div>
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
    <style>
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-white">
    <div class="max-w-7xl mx-auto p-6 print:p-4">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">{{ Auth::user()->name }}'s Timetable</h1>
            <p class="text-gray-600 mt-2 text-sm">Academic Schedule {{ now()->format('Y') }}</p>
        </div>

        @if($timetables->isEmpty())
            <div class="p-8 text-center text-gray-500">
                <p class="text-lg">No courses enrolled.</p>
            </div>
        @else
            <div class="overflow-x-auto shadow-lg rounded-lg">
                <table style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid black; padding: 8px;">Time</th>
                            @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                <th style="border: 1px solid black; padding: 8px;">{{ $day }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $startHour = 7;
                            $endHour = 19;
                        @endphp

                        @for($hour = $startHour; $hour <= $endHour; $hour++)
                            @foreach(['00', '30'] as $minute)
                                @php
                                    $currentTime = sprintf('%02d:%s', $hour, $minute);
                                    $nextTime = $minute === '00' 
                                        ? sprintf('%02d:30', $hour)
                                        : sprintf('%02d:00', $hour + 1);
                                @endphp
                                <tr>
                                    <td style="border: 1px solid black; padding: 8px;">{{ $currentTime }} - {{ $nextTime }}</td>

                                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                        <td style="border: 1px solid black; padding: 8px;">
                                            @foreach($timetables as $timetable)
                                                @if($timetable->day_of_week == $day && 
                                                    $timetable->start_time <= $currentTime && 
                                                    $timetable->end_time > $currentTime)
                                                    <div class="bg-teal-50 border border-teal-200 p-3 rounded-md shadow-sm hover:shadow-md transition-shadow duration-200">
                                                        <div class="font-medium text-teal-700 text-sm">
                                                            {{ $timetable->course_name }}
                                                        </div>
                                                        <div class="flex items-center gap-2 mt-2">
                                                            <div class="text-teal-600 text-xs flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                </svg>
                                                                {{ $timetable->place }}
                                                            </div>
                                                        </div>
                                                        <div class="text-teal-500 text-xs mt-1 flex items-center">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                            {{ $timetable->start_time }} - {{ $timetable->end_time }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center text-gray-500 text-sm border-t border-gray-200 pt-4">
                <p>Generated on {{ now()->format('l, F j, Y \a\t h:i A') }}</p>
                <p class="mt-1 text-xs text-gray-400">This schedule is subject to change. Please check regularly for updates.</p>
            </div>
        @endif
    </div>
</body>
</html>