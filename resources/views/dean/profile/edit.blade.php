<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Dean Profile</title>
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
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Navigation Buttons -->
            <div class="flex space-x-4 mb-6">
                <a href="{{ route('dean.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('dean.profile.show') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Profile
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Edit Profile Form -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Profile</h2>

                    <form action="{{ route('dean.profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Profile Photo -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                Profile Photo
                            </label>
                            <div class="flex items-center space-x-6">
                                <div class="shrink-0">
                                    <img id="preview-image" class="h-16 w-16 object-cover rounded-full"
                                        src="{{ $dean->profile_picture ? asset('storage/' . $dean->profile_picture) : asset('storage/profile_photos/default.png') }}"
                                        alt="Current profile photo">
                                </div>
                                <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="profile_picture" id="profile_picture"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100"
                                        onchange="previewImage(this)">
                                </label>
                            </div>
                            @error('profile_picture')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" id="name"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                    Address</label>
                                <input type="email" name="email" id="email"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone
                                    Number</label>
                                <input type="text" name="phone" id="phone"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    value="{{ old('phone', $dean->phone) }}" required>
                                @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="office_location" class="block text-sm font-medium text-gray-700 mb-1">Office
                                    Location</label>
                                <input type="text" name="office_location" id="office_location"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    value="{{ old('office_location', $dean->office_location) }}" required>
                                @error('office_location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-1">Staff
                                    ID</label>
                                <input type="text" name="staff_id" id="staff_id"
                                    class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500"
                                    value="{{ old('staff_id', $dean->staff_id) }}" required>
                                @error('staff_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Change Password -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="current_password"
                                        class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                                    <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
                                    @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New
                                        Password</label>
                                    <input type="password" name="new_password" id="new_password"
                                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                                    @error('new_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password_confirmation"
                                        class="block text-sm font-medium text-gray-700 mb-1">Confirm New
                                        Password</label>
                                    <input type="password" name="new_password_confirmation"
                                        id="new_password_confirmation"
                                        class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6">
                            <button type="submit"
                                class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-colors duration-200">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('preview-image');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

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
