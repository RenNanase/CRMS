<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Review</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-morphism {
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid #99f6e4;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .card-hover {
            transition: all 0.3s;
        }

        .card-hover:hover {
            transform: scale(1.01) translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .gradient-header {
            background: linear-gradient(to right, #0d9488, #14b8a6);
        }

        .form-input-modern {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 2px solid #99f6e4;
            background-color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s;
        }

        .form-input-modern:focus {
            border-color: #2dd4bf;
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.2);
            outline: none;
        }

        .info-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: rgba(240, 253, 250, 0.8);
            color: #115e59;
        }

        .status-chip {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-teal-50 via-white to-teal-50 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Breadcrumb Navigation -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="#" class="text-teal-600 hover:text-teal-800">Dashboard</a></li>
                <li class="text-gray-500">/</li>
                <li><a href="#" class="text-teal-600 hover:text-teal-800">Applications</a></li>
                <li class="text-gray-500">/</li>
                <li class="text-gray-600">Review</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="glass-morphism rounded-2xl p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Application Review</h1>
                    <p class="text-teal-700 mt-2 text-lg">Minor Program Registration Assessment</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="status-chip bg-yellow-100 text-yellow-800">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Pending Review
                    </span>
                    <a href="{{ route('dean.minor-requests.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border-2 border-teal-200 text-teal-700 rounded-xl hover:bg-teal-50 hover:border-teal-300 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Left Column: Student Information -->
            <div class="md:col-span-1 space-y-6">
                <div class="glass-morphism rounded-2xl overflow-hidden card-hover">
                    <div class="gradient-header px-6 py-4">
                        <h2 class="text-xl font-semibold text-white">Student Profile</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-teal-800">Student Name</label>
                            <p class="text-lg text-gray-900">{{ $minorRegistration->student->name }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-teal-800">Matric Number</label>
                            <p class="text-lg text-gray-900">{{ $minorRegistration->student->matric_number }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-teal-800">Current Program</label>
                            <p class="text-lg text-gray-900">{{ $minorRegistration->student->program->name }}</p>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-teal-800">Application Date</label>
                            <p class="text-lg text-gray-900">{{ $minorRegistration->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Document Preview Card -->
                <div class="glass-morphism rounded-2xl overflow-hidden card-hover">
                    <div class="gradient-header px-6 py-4">
                        <h2 class="text-xl font-semibold text-white">Supporting Document</h2>
                    </div>
                    <div class="p-6">
                        <a href="{{ Storage::disk('public')->url($minorRegistration->signed_form_path) }}"
                            class="inline-flex items-center justify-center w-full px-4 py-3 bg-teal-600 text-white rounded-xl hover:bg-teal-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            View Application Form
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Column: Review Form -->
            <div class="md:col-span-2">
                <div class="glass-morphism rounded-2xl overflow-hidden card-hover">
                    <div class="gradient-header px-6 py-4">
                        <h2 class="text-xl font-semibold text-white">Review Decision</h2>
                        <p class="text-teal-50 text-sm mt-1">Please provide your assessment</p>
                    </div>
                    <form action="{{ route('dean.minor-requests.recommendation', $minorRegistration )}}" method="POST"
                    class="p-6 space-y-6">

                            

                            @csrf
                            @method('PUT')
                            <!-- Reviewer Information -->
                            <div class="bg-teal-50/50 p-6 rounded-xl">
                                <label class="text-sm font-medium text-teal-800 mb-2 block">Dean's Name</label>
                                <input type="text" name="dean_name" value="{{ auth()->user()->name }}"class="form-input-modern"
                                    readonly>
                            </div>

                            <!-- Decision Selection -->
                            <div class="bg-teal-50/50 p-6 rounded-xl">
                                <label class="text-sm font-medium text-teal-800 mb-2 block">Decision</label>
                                <select name="recommendation_status" class="form-input-modern" required>
                                    <option value="">Select your decision</option>
                                    <option value="approved" class="text-emerald-700">Approve Application</option>
                                    <option value="rejected" class="text-red-700">Reject Application</option>
                                </select>
                            </div>

                            <!-- Comments Section -->
                            <div class="bg-teal-50/50 p-6 rounded-xl">
                                <label class="text-sm font-medium text-teal-800 mb-2 block">Assessment Comments</label>
                                <textarea name="dean_comments" rows="4" class="form-input-modern resize-none"
                                    placeholder="Leave a comment"></textarea>
                            </div>



                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-teal-100">
                            <button type="button"
                            onclick="window.location.href='{{ route('dean.minor-requests.index') }}'"
                                class="px-6 py-3 bg-white border-2 border-teal-200 text-teal-700 rounded-xl hover:bg-teal-50 hover:border-teal-300 transition-all duration-200">
                                Cancel
                            </button>

                     <button type="submit"
                                class="px-6 py-3 bg-gradient-to-r from-teal-600 to-teal-500 text-white rounded-xl hover:from-teal-700 hover:to-teal-600 shadow-md hover:shadow-lg transition-all duration-200">
                                Submit Decision
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Error Toast Notification -->
    @if(session('error'))
    <div class="fixed bottom-4 right-4 max-w-md" x-data="{ show: true }" x-show="show"
        x-init="setTimeout(() => show = false, 5000)">
        <div class="bg-white border-l-4 border-red-500 shadow-lg rounded-lg p-4 flex items-start space-x-4">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm text-gray-800">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif
</body>

</html>
