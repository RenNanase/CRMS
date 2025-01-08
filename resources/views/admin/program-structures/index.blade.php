
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Program Structure - Admin Dashboard</title>
<!-- Add these styles in your <head> section -->
<style>
    @keyframes fade-out {
        from {
            opacity: 1;
            transform: translateY(0);
        }

        to {
            opacity: 0;
            transform: translateY(-1rem);
        }
    }

    .animate-fade-out {
        animation: fade-out 0.3s ease-out forwards;
    }
</style>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                            900: '#134e4a',
                        },
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-teal-50 min-h-screen">
<!-- Top Navigation Bar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center text-teal-600 hover:text-teal-700">
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


    <!-- Success Notification -->
        @if(session('success'))
        <div id="notification" class="fixed top-4 right-4 z-50 animate-bounce">
            <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>{{ session('success') }}</span>
                <button onclick="closeNotification()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

<script>
    // Auto-hide notification after 5 seconds
            if (document.getElementById('notification')) {
                setTimeout(() => {
                    closeNotification();
                }, 5000);
            }

            function closeNotification() {
                const notification = document.getElementById('notification');
                if (notification) {
                    notification.classList.remove('animate-bounce');
                    notification.classList.add('animate-fade-out');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }
            }
</script>
@endif

<!-- Error Notification -->
    @if($errors->any())
    <div id="error-notification" class="fixed top-4 right-4 z-50">
        <div class="bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">Please fix the following errors:</span>
            </div>
            <ul class="mt-2 list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Upload Program Structure</h1>
            <p class="mt-2 text-sm text-gray-600">Add a new program structure to the system</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if($errors->any())
            <div class="bg-red-50 p-4 border-l-4 border-red-500">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.program-structures.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Program Name -->
<div>
        <label for="program_id" class="block text-sm font-medium text-gray-700">Program</label>
        <select id="program_id" name="program_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
            required disabled>
            <option value="">Select Program</option>
        </select>
    </div>

                    <!-- Faculty -->
                    <div>
                        <label for="faculty_id" class="block text-sm font-medium text-gray-700">Faculty</label>
                        <select id="faculty_id" name="faculty_id"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                            required>
                            <option value="">Select Faculty</option>
                            @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ old('faculty_id')==$faculty->id ? 'selected' : '' }}>
                                {{ $faculty->faculty_name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Academic Year -->
                    <div>
                        <label for="academic_year" class="block text-sm font-medium text-gray-700">Academic Year</label>
                        <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year') }}"
                            placeholder="e.g., 2023/2024"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                            required>
                    </div>

                    <!-- Version -->
                    <div>
                        <label for="version" class="block text-sm font-medium text-gray-700">Version (Optional)</label>
                        <input type="text" id="version" name="version" value="{{ old('version') }}"
                            placeholder="e.g., 1.0"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    </div>

                    <!-- PDF File Upload -->
                    <div class="col-span-full">
                        <label for="pdf_file" class="block text-sm font-medium text-gray-700">PDF File</label>
                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <i class="fas fa-file-pdf text-gray-400 text-3xl mb-3"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="pdf_file"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-teal-600 hover:text-teal-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-teal-500">
                                        <span>Upload a file</span>
                                        <input id="pdf_file" name="pdf_file" type="file" class="sr-only" accept=".pdf"
                                            required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Active Status -->
                    <div class="col-span-full">
                        <div class="relative flex items-start">
                            <div class="flex items-center h-5">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active',
                                    true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700">Set as Active Version</label>
                                <p class="text-gray-500">Make this the current active version for the program</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-6 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.program-structures.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500">
                        <i class="fas fa-upload mr-2"></i>
                        Upload Structure
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- File Upload Preview Script -->
    <script>
        const fileInput = document.getElementById('pdf_file');
        const fileLabel = document.querySelector('[for="pdf_file"]');
        const defaultText = fileLabel.innerHTML;

        fileInput.addEventListener('change', (e) => {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                fileLabel.innerHTML = `Selected: ${fileName}`;
            } else {
                fileLabel.innerHTML = defaultText;
            }
        });

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-teal-500', 'bg-teal-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-teal-500', 'bg-teal-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;

            if (files[0]) {
                fileLabel.innerHTML = `Selected: ${files[0].name}`;
            }
        }

// Add this to handle error notification
        if (document.getElementById('error-notification')) {
        setTimeout(() => {
        const errorNotification = document.getElementById('error-notification');
        if (errorNotification) {
        errorNotification.classList.add('animate-fade-out');
        setTimeout(() => {
        errorNotification.remove();
        }, 300);
        }
        }, 8000);
        }

        // Add this new script for faculty-program relationship
document.addEventListener('DOMContentLoaded', function() {
const facultySelect = document.getElementById('faculty_id');
const programSelect = document.getElementById('program_id');
const debugDiv = document.getElementById('debug-info');

facultySelect.addEventListener('change', async function() {
const facultyId = this.value;
console.log('Selected Faculty ID:', facultyId); // Debug log

programSelect.innerHTML = '<option value="">Select Program</option>';

if(facultyId) {
try {
// Use the full URL path
const url = `/admin/get-programs/${facultyId}`;
console.log('Fetching URL:', url); // Debug log

const response = await fetch(url, {
method: 'GET',
headers: {
'Accept': 'application/json',
'X-Requested-With': 'XMLHttpRequest'
}
});

if (!response.ok) {
throw new Error(`HTTP error! status: ${response.status}`);
}

const programs = await response.json();
console.log('Received programs:', programs); // Debug log

if (programs && programs.length > 0) {
programs.forEach(program => {
const option = document.createElement('option');
option.value = program.id;
option.textContent = program.name;
programSelect.appendChild(option);
});
programSelect.disabled = false;
} else {
programSelect.innerHTML = '<option value="">No programs found</option>';
}
} catch (error) {
console.error('Error:', error);
programSelect.innerHTML = '<option value="">Error loading programs</option>';
programSelect.disabled = true;
}
} else {
programSelect.disabled = true;
}
});
});
    </script>
</body>

</html>
