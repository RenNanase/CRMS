<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Course</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

</head>
<body class="bg-gradient-to-br from-teal-50 to-teal-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="bg-teal-600 text-white px-4 py-2 rounded-md hover:bg-teal-700 transition duration-300">Home</a>
        </div>
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="bg-pink-600 text-white p-6">
                <h1 class="text-3xl font-bold">Create Course</h1>
            </div>
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div class="form-group px-6 py-4">
                    <label for="course_name" class="block text-lg font-medium text-gray-700">Course Name</label>
                    <input type="text" name="course_name" class="form-control mt-1 block w-full custom-border rounded-md shadow-sm h-12 px-4 custom-focus" value="{{ old('course_name', $course->course_name ?? '') }}" required>
                </div>
                <div class="form-group px-6 py-4">
                    <label for="course_code" class="block text-lg font-medium text-gray-700">Course Code</label>
                    <input type="text" name="course_code" class="form-control mt-1 block w-full custom-border rounded-md shadow-sm h-12 px-4 custom-focus" value="{{ old('course_code', $course->course_code ?? '') }}" required>
                </div>
                <div class="form-group px-6 py-4">
                    <label for="credit_hours" class="block text-lg font-medium text-gray-700">Credit Hours</label>
                    <input type="number" name="credit_hours" class="form-control mt-1 block w-full custom-border rounded-md shadow-sm h-12 px-4 custom-focus" value="{{ old('credit_hours', $course->credit_hours ?? '') }}" required>
                </div>
                <div class="form-group px-6 py-4">
                    <label for="capacity" class="block text-lg font-medium text-gray-700">Capacity</label>
                    <input type="number" name="capacity" class="form-control mt-1 block w-full custom-border rounded-md shadow-sm h-12 px-4 custom-focus" placeholder="Optional">
                </div>
                <div class="form-group px-6 py-4">
                    <label for="faculty_id" class="block text-lg font-medium text-gray-700">Select Faculty</label>
                    <select name="faculty_id" class="form-control mt-1 block w-full custom-border rounded-md shadow-sm h-12 px-4 custom-focus" required>
                        <option value="">Select Faculty</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}">{{ $faculty->faculty_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group px-6 py-4">
        <label for="prerequisites" class="block text-lg font-medium text-gray-700">Select Prerequisites:</label>
        <select name="prerequisite_ids[]" class="form-control mt-1 block w-full border-teal-500 rounded-md shadow-sm h-10 px-4 focus:border-teal-700 focus:ring focus:ring-teal-200 focus:ring-opacity-50" multiple id="prerequisites">
            @foreach($courses as $prerequisite)
                <option value="{{ $prerequisite->id }}">{{ $prerequisite->course_name }}</option>
            @endforeach
        </select>
    </div>
                <div class="form-group px-6 py-4">
                    <label for="type" class="block text-lg font-medium text-gray-700">Course Type</label>
                    <select name="type" class="form-control mt-1 block w-full custom-border rounded-md shadow-sm h-12 px-4 custom-focus" required>
                        <option value="major">Major</option>
                        <option value="minor">Minor</option>
                    </select>
                </div>
                <div class="bg-pink-50 px-6 py-4 flex justify-between items-center">
                    <button type="submit" class="bg-pink-600 text-white px-6 py-2 rounded-md hover:bg-pink-700 transition duration-300">Save</button>
                    <a href="{{ route('admin.courses.index') }}" class="bg-red-700 text-white px-6 py-2 rounded-md hover:bg-gray-500 transition duration-300">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Include jQuery and Select2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#prerequisites').select2({
                    placeholder: "Select Prerequisites",
                    allowClear: true,
                    width: '100%',
                    minimumResultsForSearch: Infinity // Disable search box if not needed
                });
            });
        </script>

</body>
</html>