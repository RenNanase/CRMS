<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Profile</title>
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

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Top Navigation Bar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <a href="{{ route('student.dashboard') }}"class="flex items-center text-teal-600 hover:text-teal-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-teal-600 px-6 py-4">
                    <h2 class="text-white text-xl font-semibold">Edit Profile</h2>
                </div>

<div class="p-6">
            <form method="POST" action="{{ route('student.profile.update', ['id' => $student->id]) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Profile Photo Section -->
<div class="p-8 space-y-6">
    <form method="POST" action="{{ route('student.profile.update', ['id' => $student->id]) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Profile Photo Section -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Profile Photo</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-8">
                    <div class="relative shrink-0">
                        @if($student->photo)
                        <img src="{{ asset('storage/' . $student->photo) }}" alt="Current Profile Photo"
                            class="w-32 h-32 rounded-full object-cover ring-4 ring-teal-100 border border-gray-200">
                        <span
                            class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white bg-green-400"></span>
                        @else
                        <div
                            class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload new photo</label>
                        <input type="file" name="photo"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                        <p class="mt-2 text-sm text-gray-500">Recommended: Square image, at least 400x400 pixels</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Personal Information Section -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}"
                            class="w-full rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-teal-500 bg-white px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone', $student->phone) }}"
                            class="w-full rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-teal-500 bg-white px-4 py-2.5">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                        <textarea name="address" rows="3"
                            class="w-full rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-teal-500 bg-white px-4 py-2.5">{{ old('address', $student->address) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information Section -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Academic Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Matric Number</label>
                        <input type="text" name="matric_number"
                            value="{{ old('matric_number', $student->matric_number) }}"
                            class="w-full rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-teal-500 bg-white px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Program</label>
                        <input type="text" name="programme" value="{{ old('programme', $student->program_name) }}"
                            class="w-full rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-teal-500 bg-white px-4 py-2.5">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Batch</label>
                        <input type="text" name="batch" value="{{ old('batch', $student->batch) }}"
                            class="w-full rounded-lg border border-gray-300 focus:border-teal-500 focus:ring-teal-500 bg-white px-4 py-2.5">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200 shadow-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h1a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h1v5.586l-1.293-1.293zM9 5a1 1 0 012 0v6.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9 11.586V5z" />
                </svg>
                Save Changes
            </button>
        </div>
    </form>
</div>
</div>
</div>olk


    </div>
</body>
</html>
