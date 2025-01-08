<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
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

<!-- Add this near the top of your form -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Success!</strong>
    <span class="block sm:inline">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Error!</strong>
    <span class="block sm:inline">{{ session('error') }}</span>
</div>
@endif

@if ($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
    <strong class="font-bold">Validation Error!</strong>
    <ul class="mt-2">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4">
                <h2 class="text-2xl font-bold">Add New Student</h2>
            </div>

            <!-- Form Section -->
            <div class="p-6">
                <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-medium text-teal-700 border-b border-teal-200 pb-2">Personal Information</h3>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" id="name" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" id="email" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" name="phone" id="phone" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <textarea name="address" id="address" rows="3" required
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"></textarea>
                            </div>
                        </div>

<!-- Academic Information -->
<div class="space-y-6">
    <h3 class="text-lg font-medium text-teal-700 border-b border-teal-200 pb-2">Academic Information</h3>

    <div>
        <label for="matric_number" class="block text-sm font-medium text-gray-700 mb-1">Matric Number</label>
        <input type="text" name="matric_number" id="matric_number" required
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
    </div>

    <div>
        <label for="ic_number" class="block text-sm font-medium text-gray-700 mb-1">IC Number</label>
        <input type="text" name="ic_number" id="ic_number" required
            class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
    </div>

    <div class="space-y-6">
        <div>
            <label for="faculty_id" class="block text-sm font-medium text-gray-700 mb-1">Faculty</label>
<select name="faculty_id" id="faculty_id" required>
    <option value="">Select Faculty</option>
    @foreach($faculties as $faculty)
    <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
    @endforeach
</select>
        </div>

        <div>
            <label for="program_id" class="block text-sm font-medium text-gray-700 mb-1">Program</label>
            <select name="program_id" id="program_id" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                <option value="">Select Faculty First</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="current_semester" class="block text-sm font-medium text-gray-700 mb-1">Current Semester</label>
            <input type="number" name="current_semester" id="current_semester" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
        </div>

        <div>
            <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Academic Year</label>
            <input type="text" name="academic_year" id="academic_year" required
                class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
        </div>
    </div>

                            <div>
                                <label for="scholarship_status" class="block text-sm font-medium text-gray-700 mb-1">Scholarship Status</label>
<select name="scholarship_status" id="scholarship_status" required
    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
    <option value="">Select Scholarship Status</option>
    <option value="Scholarship">Scholarship</option>
    <option value="Non-Scholarship">Non-Scholarship</option>
</select>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="border-t border-teal-200 pt-6">
                        <h3 class="text-lg font-medium text-teal-700 mb-4">Account Credentials</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <button type="button" onclick="togglePasswordVisibility('password')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="relative">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <button type="submit"
                                class="px-6 py-3 bg-teal-600 text-white rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition duration-150">
                            Create Student
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const button = field.nextElementSibling.querySelector('i');

            if (field.type === 'password') {
                field.type = 'text';
                button.classList.remove('fa-eye');
                button.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                button.classList.remove('fa-eye-slash');
                button.classList.add('fa-eye');
            }
        }

        //to fetch the program
document.addEventListener('DOMContentLoaded', function() {
const facultySelect = document.getElementById('faculty_id');

facultySelect.addEventListener('change', function() {
const facultyId = this.value;
loadPrograms(facultyId);
});
});

function loadPrograms(facultyId) {
const programSelect = document.getElementById('program_id');

if (!facultyId) {
programSelect.innerHTML = '<option value="">Select Faculty First</option>';
return;
}

fetch(`/api/faculties/${facultyId}/programs`)
.then(response => {
if (!response.ok) {
throw new Error('Network response was not ok');
}
return response.json();
})
.then(programs => {
let options = '<option value="">Select Program</option>';
programs.forEach(program => {
options += `<option value="${program.id}">${program.name} (${program.code})</option>`;
});
programSelect.innerHTML = options;
})
.catch(error => {
console.error('Error:', error);
programSelect.innerHTML = '<option value="">Error loading programs</option>';
});
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
