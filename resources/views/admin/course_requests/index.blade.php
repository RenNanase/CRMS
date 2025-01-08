<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Course Requests Management</title>
    <thead class="bg-teal-600 text-white"></thead>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        .fade-out {
            animation: fadeOut 0.5s ease forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .notification {
            position: fixed;
            top: 1rem;
            right: 1rem;
            padding: 1rem;
            border-radius: 0.5rem;
            z-index: 50;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        .notification.show {
            transform: translateX(0);
        }

        tr.highlight {
            background-color: rgba(13, 148, 136, 0.05);
        }
    </style>
</head>

<body class="bg-gradient-to-br from-teal-50 to-gray-50">
    <!-- Notification Container -->
    <div id="notification" class="notification hidden bg-teal-600 text-white shadow-lg">
        <span id="notificationMessage"></span>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Header and Navigation -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-teal-700">Course Requests Management</h1>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6 border border-teal-100">
                <form action="{{ route('admin.course-requests.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-teal-700 mb-2">Program</label>
                        <select name="program" class="w-full rounded-lg border-teal-200 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                            <option value="">All Programs</option>
                            <option value="FIT" {{ request('program') == 'FIT' ? 'selected' : '' }}>FIT</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-teal-700 mb-2">Student Status</label>
                        <select name="student_status" class="w-full rounded-lg border-teal-200 shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                            <option value="">All Status</option>
                            <option value="scholarship" {{ request('student_status') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                            <option value="non-scholarship" {{ request('student_status') == 'non-scholarship' ? 'selected' : '' }}>Non-Scholarship</option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-4">
                    <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-all duration-300 shadow-sm hover:shadow-md">
    Apply Filters
</button>
                        <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden border border-teal-100">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-teal-50 border-b border-teal-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Student Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">Matric Number</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Course</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Course Code</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Group</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Receipt Payment</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Student Status</th>
                            <th class="px-6 py-4 text-center text-xs font-medium text-teal-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-teal-100">
                        @foreach($courseRequests as $request)
                        <tr id="request-{{ $request->id }}" class="hover:bg-teal-50 transition-all duration-300">
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900">{{ $request->student_name }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900">{{ $request->matric_number }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900">{{ $request->course ? $request->course->course_name : 'N/A' }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900">{{ $request->course_code }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm text-gray-900">{{ $request->group ? $request->group->group_name : 'N/A' }}</td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                @if($request->student_status === 'scholarship')
                                    <span class="text-gray-500 italic">Not Applicable</span>
                                @else
                                    @if($request->fee_receipt)
                                        <a href="{{ url('storage/' . $request->fee_receipt) }}"
                                           target="_blank"
                                           class="text-teal-600 hover:text-teal-800 underline transition-all duration-300">
                                            View Receipt
                                        </a>
                                    @else
                                        <span class="text-gray-500 italic">No Receipt</span>
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center text-sm">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ $request->student_status === 'scholarship' ? 'bg-teal-100 text-teal-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($request->student_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap text-sm font-medium">
                                @if($request->status === 'pending')
                                <div class="flex justify-center space-x-2">
                                    <button onclick="handleApprove({{ $request->id }})"
                                            class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                                        Approve
                                    </button>
                                    <button onclick="openRejectModal({{ $request->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm transition-all duration-300 shadow-sm hover:shadow-md">
                                        Reject
                                    </button>
                                </div>
                                @else
                                    <span class="text-gray-500">{{ ucfirst($request->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-teal-900 mb-4">Reject Request</h3>
                <textarea id="remarks"
                          class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:ring focus:ring-teal-200 focus:border-teal-500"
                          rows="4"
                          placeholder="Enter rejection remarks..."></textarea>
                <div class="mt-4 flex justify-end space-x-3">
                    <button onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300">
                        Cancel
                    </button>
                    <button onclick="handleReject()"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-300">
                        Reject
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    let selectedRequestId = null;

    function showNotification(message, success = true) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notificationMessage');

        notification.classList.remove('hidden');
        notification.classList.add('show');
        notification.classList.toggle('bg-teal-600', success);
        notification.classList.toggle('bg-red-500', !success);
        notificationMessage.textContent = message;

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 300);
        }, 3000);
    }

    function removeTableRow(requestId) {
        const row = document.getElementById(`request-${requestId}`);
        if (row) {
            // Add highlight effect before removal
            row.classList.add('highlight');
            setTimeout(() => {
                row.classList.add('fade-out');
                setTimeout(() => {
                    row.remove();
                    // Check if table is empty
                    const tbody = document.querySelector('tbody');
                    if (tbody.children.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="8" class="px-6 py-4 text-center text-gray-500">No pending requests</td></tr>';
                    }
                }, 500);
            }, 100);
        }
    }

    async function handleApprove(requestId) {
    try {
        const response = await fetch(`/admin/course-requests/${requestId}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Request approved successfully');
            removeTableRow(requestId);
        } else {
            showNotification(data.message || 'Failed to approve request', false);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while processing the request', false);
    }
}

    function openRejectModal(requestId) {
        selectedRequestId = requestId;
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('hidden');
        document.getElementById('remarks').value = '';
        document.getElementById('remarks').focus();
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        selectedRequestId = null;
    }

    async function handleReject() {
    const remarks = document.getElementById('remarks').value;

    if (!remarks.trim()) {
        showNotification('Please provide rejection remarks', false);
        return;
    }

    try {
        const response = await fetch(`/admin/course-requests/${selectedRequestId}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ remarks: remarks })
        });

        const data = await response.json();

        if (data.success) {
            showNotification('Request rejected successfully');
            removeTableRow(selectedRequestId);
            closeRejectModal();
        } else {
            showNotification(data.message || 'Failed to reject request', false);
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while processing the request', false);
        closeRejectModal();
    }
}

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !document.getElementById('rejectModal').classList.contains('hidden')) {
            closeRejectModal();
        }
    });

    // Prevent modal close when clicking inside the modal content
    document.querySelector('#rejectModal > div').addEventListener('click', function(e) {
        e.stopPropagation();
    });
    </script>
</body>
</html>
