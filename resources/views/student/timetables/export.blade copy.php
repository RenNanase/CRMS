@php
use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @page {
            margin: 20px;
            size: A4 landscape;
        }

        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        /* Additional print styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            /* Smaller font size for better fit */
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 6px;
            /* Reduced padding */
        }

        th {
            background-color: #f8fafc;
        }

        .course-block {
            padding: 4px 6px;
            /* Compact padding */
            border-radius: 4px;
            margin-bottom: 2px;
        }
    </style>
</head>

<body class="bg-white min-h-screen">
    <div class="max-w-[1400px] mx-auto p-6 print:p-4">
        <!-- Header Section - More compact -->
        <div class="mb-4 text-center">
            <h1 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}'s Timetable</h1>
            <p class="text-gray-600 mt-1 text-xs">Academic Schedule {{ now()->format('Y') }}</p>
        </div>

        <!-- Quote Section - More compact -->
        <div class="mb-4 text-center w-full">
            <p class="text-gray-600 italic mx-auto max-w-2xl text-sm">
                "If you don't discipline yourself now, life will discipline you later and it won't be kind"
            </p>
        </div>



        @if($timetables->isEmpty())
        <div class="p-4 text-center text-gray-500">
            <p>No courses enrolled.</p>
        </div>
        @else
        <!-- Timetable Section -->
        <div class="overflow-x-auto shadow-sm rounded-lg">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left font-semibold text-gray-700">Time</th>
                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Saturday'] as $day)
                        <th class="text-left font-semibold text-gray-700">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @for($hour = 7; $hour <= 19; $hour++) <tr>
                        <td class="text-gray-500 border-t">
                            {{ sprintf('%02d:00', $hour) }} - {{ sprintf('%02d:00', $hour + 1) }}
                        </td>

                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Saturday'] as $day)
                        <td class="border-t">
                            @foreach($timetables as $timetable)
                            @if($timetable->day_of_week == $day &&
                            Carbon::parse($timetable->start_time)->format('H') == $hour)
                            <div class="course-block {{ $timetable->source === 'minor'
                                                    ? 'bg-indigo-50 border border-indigo-200'
                                                    : 'bg-teal-50 border border-teal-200' }}">
                                <!-- Course Name -->
                                <div class="font-medium {{ $timetable->source === 'minor'
                                                        ? 'text-indigo-700'
                                                        : 'text-teal-700' }}">
                                    {{ $timetable->course_name }}
                                </div>

                                <!-- Place and Time - Single line -->
                                <div class="{{ $timetable->source === 'minor'
                                                        ? 'text-indigo-600'
                                                        : 'text-teal-600' }}">
                                    {{ $timetable->place }} •
                                    {{ Carbon::parse($timetable->start_time)->format('H:i') }}-
                                    {{ Carbon::parse($timetable->end_time)->format('H:i') }}
                                </div>
                            </div>
                            @endif
                            @endforeach
                        </td>
                        @endforeach
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>

        <!-- Footer Section - More compact -->
        <div class="mt-4 text-center text-xs text-gray-500 border-t border-gray-200 pt-2">
            <p>Generated on {{ now()->format('l, F j, Y \a\t h:i A') }}</p>
            <p class="mt-1 text-gray-400">This schedule is subject to change. Please check regularly for updates.</p>
        </div>
        @endif
    </div>
</body>

</html>
