<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dean Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                        <a href="{{ route('dean.dashboard') }}"
                            class="flex items-center text-teal-600 hover:text-teal-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Column - Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <div class="flex flex-col items-center">
                                @if($dean->profile_picture)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $dean->profile_picture) }}" alt="Profile Picture"
                                        class="w-32 h-32 rounded-full object-cover ring-4 ring-teal-100">
                                    <span
                                        class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white bg-green-400"></span>
                                </div>
                                @else
                                <div class="relative">
                                    <img src="{{ asset('storage/profile_photos/default.png') }}"
                                        alt="Default Profile Picture"
                                        class="w-32 h-32 rounded-full object-cover ring-4 ring-teal-100">
                                    <span
                                        class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 ring-white bg-green-400"></span>
                                </div>
                                @endif
                                <h2 class="mt-4 text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                                <p class="text-teal-600 font-medium">Dean</p>
                            </div>

                            <div class="mt-6 flex justify-center">
                                <a href="{{ route('dean.profile.edit') }}"
                                    class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Profile Information -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6">Profile Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                <!-- Personal Information -->
                                <div class="space-y-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Email Address</h4>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-teal-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <p class="text-gray-900">{{ $user->email }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Phone Number</h4>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-teal-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <p class="text-gray-900">{{ $dean->phone }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Faculty</h4>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-teal-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-gray-900">{{ $dean->faculty }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Office Information -->
                                <div class="space-y-6">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Office Location</h4>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-teal-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <p class="text-gray-900">{{ $dean->office_location }}</p>
                                        </div>
                                    </div>

                                    @if($dean->staff_id)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 mb-1">Staff ID</h4>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-teal-500 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                            <p class="text-gray-900">{{ $dean->staff_id }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Last Updated Info -->
                            <div class="mt-8 p-4 bg-teal-50 rounded-xl">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-teal-600 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-teal-600">Last updated: {{ $dean->updated_at->format('d M
                                        Y, h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('[role="alert"]');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease-in-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000);
        });
    </script>
</body>

</html>
