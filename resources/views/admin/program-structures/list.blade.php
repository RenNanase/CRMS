<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Structures - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-teal-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center text-teal-600 hover:text-teal-700">
                        <i class="fas fa-home mr-2"></i>
                        <span class="font-medium">Dashboard</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Program Structures</h1>
                <p class="mt-2 text-sm text-gray-600">View all program structures by faculty and program</p>
            </div>
            <a href="{{ route('admin.program-structures.index') }}"
                class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i>
                Add New Program Structure
            </a>
        </div>

        <!-- Faculties Grid -->
        <div class="grid grid-cols-1 gap-6">
            @foreach($faculties as $faculty)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <!-- Faculty Header -->
                <div class="bg-teal-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white">
                        <i class="fas fa-university mr-2"></i>
                        {{ $faculty->faculty_name }}
                    </h2>
                </div>

                <!-- Programs List -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($faculty->programs as $program)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">
                                <i class="fas fa-graduation-cap mr-2 text-teal-600"></i>
                                {{ $program->name }}
                            </h3>

                            @if($program->programStructures->count() > 0)
                            <div class="space-y-3">
                                @foreach($program->programStructures as $structure)
                                <div class="bg-white p-4 rounded-md shadow-sm border border-gray-100">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $structure->academic_year }}
                                                @if($structure->version)
                                                <span class="text-gray-500">(v{{ $structure->version }})</span>
                                                @endif
                                            </p>
                                            @if($structure->is_active)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                                Active
                                            </span>
                                            @endif
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ Storage::url($structure->pdf_path) }}" target="_blank"
                                                class="text-teal-600 hover:text-teal-700">
                                                <i class="fas fa-file-pdf"></i>
                                            </a>
                                            <a href="{{ route('admin.program-structures.index', $structure->id) }}"
                                                class="text-gray-600 hover:text-gray-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4 text-gray-500">
                                <i class="fas fa-folder-open text-2xl mb-2"></i>
                                <p>No structures yet</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Floating Action Button for Mobile -->
    <div class="fixed bottom-6 right-6 md:hidden">
        <a href="{{ route('admin.program-structures.create') }}"
            class="flex items-center justify-center w-14 h-14 bg-teal-600 text-white rounded-full shadow-lg hover:bg-teal-700 transition-colors duration-200">
            <i class="fas fa-plus text-lg"></i>
        </a>
    </div>
</body>

</html>
