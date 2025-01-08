<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Management</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .news-card:hover .edit-button {
            opacity: 1;
        }

        .news-card .edit-button {
            opacity: 0;
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-6">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <h2 class="text-2xl font-bold">News Management</h2>
                <a href="{{ route('news.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-white text-teal-600 rounded-md hover:bg-teal-50 transition duration-150">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create News
                </a>
            </div>

            <!-- Filter Section -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-wrap gap-4 items-center">
                    <div class="flex-1 min-w-[200px]">
                        <input type="text" placeholder="Search news..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-transparent">
                    </div>
                    <select class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500">
                        <option>Latest First</option>
                        <option>Oldest First</option>
                        <option>Most Viewed</option>
                    </select>
                </div>
            </div>

            <!-- News Grid -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $item)
                    <div
                        class="news-card bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200">
                        @if($item->image)
                        <div class="relative h-48 overflow-hidden rounded-t-xl">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                class="w-full h-full object-cover transform hover:scale-105 transition duration-500">
                        </div>
                        @endif

                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-teal-600">
                                {{ $item->title }}
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $item->content }}</p>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-teal-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>{{ $item->user->name }}</span>
                                </div>
                                <span class="mx-2">•</span>
                                <span>{{ $item->created_at->format('M d, Y') }}</span>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <span class="text-sm text-gray-500">
                                    <svg class="w-4 h-4 inline mr-1 text-teal-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    1.2k views
                                </span>
                                <a href="{{ route('news.edit', $item) }}"
                                    class="edit-button inline-flex items-center px-3 py-1.5 bg-teal-50 text-teal-600 rounded-md hover:bg-teal-100 transition-colors duration-200 text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Empty State -->
                @if($news->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No news articles</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new news article.</p>
                    <div class="mt-6">
                        <a href="{{ route('news.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-md">
                            Create your first article
                        </a>
                    </div>
                </div>
                @endif

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
