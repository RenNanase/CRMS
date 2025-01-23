<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News - News Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Add QuillJS CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Add QuillJS library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        /* QuillJS Custom Styles */
        .ql-editor {
            min-height: 200px;
            max-height: 400px;
            overflow-y: auto;
        }

        .ql-toolbar.ql-snow {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            border-color: #e5e7eb;
        }

        .ql-container.ql-snow {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
            border-color: #e5e7eb;
        }

        .ql-editor:focus {
            outline: 2px solid #0d9488;
            outline-offset: -2px;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-teal-50 to-teal-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-teal-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('news.index') }}" class="text-white text-xl font-bold">News Portal</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Breadcrumb -->
            <div class="flex items-center mb-6 text-sm">
                <a href="{{ route('news.index') }}" class="text-teal-600 hover:text-teal-800">News</a>
                <svg class="h-4 w-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="text-gray-600">Edit News</span>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Article</h2>

                    @if ($errors->any())
                    <div class="mb-4 bg-red-50 text-red-500 p-4 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="title">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200"
                                id="title" type="text" name="title" value="{{ old('title', $news->title) }}" required>
                        </div>

                        <!-- Current Image Display -->
                        @if($news->image)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Current Image
                            </label>
                            <div class="w-full flex justify-center items-center">
                                <div class="max-w-md w-full">
                                    <img src="{{ asset('storage/' . $news->image) }}" alt="Current image"
                                        class="rounded-lg shadow-md max-h-48 object-cover w-full mx-auto">
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Image Upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="image">
                                Change Image (Optional)
                            </label>
                            <div class="mt-1 flex flex-col items-center">
                                <div class="w-full">
                                    <label
                                        class="flex flex-col items-center px-4 py-6 bg-white text-teal-600 rounded-lg border-2 border-teal-300 border-dashed cursor-pointer hover:border-teal-500">
                                        <div id="preview-container" class="hidden mb-4">
                                            <img id="preview-image" src="#" alt="Preview" class="max-h-48 rounded">
                                        </div>
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="mt-2 text-base">Select a new file</span>
                                        <span class="mt-1 text-sm text-gray-500">or drag and drop</span>
                                        <input type="file" class="hidden" id="image" name="image" accept="image/*"
                                            onchange="previewImage(this)">
                                    </label>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>

                        <!-- Content Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="content">
                                Content <span class="text-red-500">*</span>
                            </label>
                            <!-- Hidden input to store the content value -->
                            <input type="hidden" name="content" id="content">
                            <!-- Quill Editor Container -->
                            <div id="editor" class="bg-white rounded-lg">
                                {!! old('content', $news->content) !!}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t">
                            <a href="{{ route('news.index') }}"
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition duration-200">
                                Update Article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add QuillJS Initialization -->
    <script>
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Write your article content here...',
        });

        // Update hidden input before form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            var content = document.querySelector('#content');
            content.value = quill.root.innerHTML;
        });

        // Initialize with existing content
        @if(old('content'))
            quill.root.innerHTML = {!! json_encode(old('content')) !!};
        @else
            quill.root.innerHTML = {!! json_encode($news->content) !!};
        @endif
    </script>

    <script>
        function previewImage(input) {
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
