<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Group Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .bg-teal-100 {
            background-color: #B2F5EA;
        }

        .bg-teal-600 {
            background-color: #319795;
        }

        .text-teal-700 {
            color: #285E61;
        }

        .hover\:bg-teal-700:hover {
            background-color: #2C7A7B;
        }

        .btn-outline-danger {
            color: #E53E3E;
            border-color: #E53E3E;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #E53E3E;
            border-color: #E53E3E;
        }

        .progress-bar {
            transition: width 0.3s ease;
            background-color: #319795;
        }

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table th {
            font-weight: 600;
            border-bottom: 2px solid #E2E8F0;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-teal {
            background-color: #319795;
            color: white;
        }

        .btn-teal:hover {
            background-color: #2C7A7B;
            color: white;
        }

        .modal-header {
            background-color: #319795;
            color: white;
        }

        .form-label {
            color: #285E61;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">

<!-- Navigation Buttons -->
    <div class="flex space-x-4 mb-4">
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

        <div class="row mb-4">
            <div class="col">
                <h2 class="text-teal-700 font-bold text-2xl">Group Management</h2>
                <button type="button" class="btn btn-teal" data-bs-toggle="modal" data-bs-target="#createGroupModal">
                    <i class="fas fa-plus-circle me-2"></i>Create New Group
                </button>
            </div>
        </div>

        <!-- Groups Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="bg-teal-100">
                        <tr>
                            <th>Course Code</th>
                            <th>Course Name</th>
                            <th>Group Name</th>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Place</th>
                            <th>Capacity</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $group)
                        <tr>
                            <td>{{ $group->course->course_code }}</td>
                            <td>{{ $group->course->course_name }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->day_of_week }}</td>
                            <td>{{ date('h:i A', strtotime($group->time)) }}</td>
                            <td>{{ $group->course->place }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        {{ $group->enrollments_count }}/{{ $group->max_students }}
                                    </div>
                                    <div class="progress flex-grow-1" style="height: 8px;">
                                        <div class="progress-bar bg-teal-500"
                                             role="progressbar"
                                             style="width: {{ ($group->enrollments_count / $group->max_students) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteGroup({{ $group->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">No groups found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Group Modal -->
        <div class="modal fade" id="createGroupModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Group</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="createGroupForm">
                            <div class="mb-3">
                                <label for="course_id" class="form-label">Course</label>
                                <select class="form-select" id="course_id" name="course_id" required>
                                    <option value="">Select Course</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Group Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="max_students" class="form-label">Maximum Students</label>
                                <input type="number" class="form-control" id="max_students" name="max_students" required
                                    min="1">
                            </div>
                            <div class="mb-3">
                                <label for="day_of_week" class="form-label">Day of Week</label>
                                <select class="form-select" id="day_of_week" name="day_of_week" required>
                                    <option value="">Select Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Saturday</option>
                                </select>
                                <small class="text-muted">Auto-filled based on course timetable</small>
                            </div>
                            <div class="mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                                <small class="text-muted">Auto-filled based on course timetable</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-teal" onclick="createGroup()">Create Group</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadFormData();
        });

        function loadFormData() {
            fetch('/admin/get-form-data')
                .then(response => response.json())
                .then(data => {
                    const courseSelect = document.getElementById('course_id');
                    courseSelect.innerHTML = '<option value="">Select Course</option>';

                    data.courses.forEach(course => {
                        courseSelect.innerHTML += `
                            <option value="${course.id}"
                                    data-day="${course.day_of_week}"
                                    data-start="${course.start_time}"
                                    data-end="${course.end_time}"
                                    data-place="${course.place}"
                                    data-type="${course.type}">
                                ${course.course_code} - ${course.course_name} (${course.start_time} - ${course.end_time})
                            </option>
                        `;
                    });

                    // Add event listener to course select
                    courseSelect.addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];

                        if (selectedOption.value) {
                            // Auto-fill and disable form fields
                            document.getElementById('day_of_week').value = selectedOption.dataset.day;
                            document.getElementById('time').value = selectedOption.dataset.start;

                            // Add additional info
                            const infoDiv = document.createElement('div');
                            infoDiv.className = 'mt-2 text-muted';
                            infoDiv.innerHTML = `
                                <small>
                                    Time: ${selectedOption.dataset.start} - ${selectedOption.dataset.end}<br>
                                    Location: ${selectedOption.dataset.place}<br>
                                    Type: ${selectedOption.dataset.type}
                                </small>
                            `;

                            // Update or add the info div
                            const existingInfo = document.querySelector('.course-info');
                            if (existingInfo) {
                                existingInfo.replaceWith(infoDiv);
                            } else {
                                document.getElementById('course_id').parentNode.appendChild(infoDiv);
                            }
                            infoDiv.className = 'course-info ' + infoDiv.className;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading form data:', error);
                    showAlert('Failed to load form data', 'error');
                });
        }

        function createGroup() {
            // Get the selected course option
            const courseSelect = document.getElementById('course_id');
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];

            const formData = {
                course_id: courseSelect.value,
                name: document.getElementById('name').value,
                max_students: document.getElementById('max_students').value,
                day_of_week: selectedOption.dataset.day,
                time: selectedOption.dataset.start, // Use the start_time directly from timetable
            };

            console.log('Sending form data:', formData); // Debug log

            fetch('/admin/groups', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('Group created successfully!', 'success');
                    $('#createGroupModal').modal('hide');
                    document.getElementById('createGroupForm').reset();
                    location.reload();
                } else {
                    showAlert(data.message || 'Failed to create group', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Failed to create group', 'error');
            });
        }

        function deleteGroup(groupId) {
            if (confirm('Are you sure you want to delete this group?')) {
                fetch(`/admin/groups/${groupId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('Group deleted successfully!', 'success');
                        location.reload();
                    } else {
                        showAlert(data.message || 'Failed to delete group', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Failed to delete group', 'error');
                });
            }
        }

        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);

            setTimeout(() => {
                alertDiv.remove();
            }, 3000);
        }

        function fetchGroups(courseId) {
            if (!courseId) return;

            console.log('Fetching groups for course:', courseId);

            // Update the fetch URL to match the route
            fetch(`/courses/${courseId}/groups`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received data:', data);

                    const groupSelect = document.getElementById('group_id');
                    if (!groupSelect) {
                        console.error('Could not find group_id select element');
                        return;
                    }

                    groupSelect.innerHTML = '<option value="">Select a group</option>';

                    if (data.success && data.groups && data.groups.length > 0) {
                        data.groups.forEach(group => {
                            console.log('Processing group:', group);
                            const option = document.createElement('option');
                            option.value = group.id;
                            option.textContent = `${group.name} - ${group.schedule} (${group.availability})`;
                            if (group.is_full) {
                                option.disabled = true;
                                option.textContent += ' (FULL)';
                            }
                            groupSelect.appendChild(option);
                        });
                    } else {
                        console.log('No groups found or error in data');
                        groupSelect.innerHTML += '<option disabled>No groups available</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching groups:', error);
                });
        }

        // Only add the event listener if the element exists
        document.addEventListener('DOMContentLoaded', function() {
            const courseSelect = document.getElementById('course');
            if (courseSelect) {
                courseSelect.addEventListener('change', function() {
                    fetchGroups(this.value);
                });
            }
        });
    </script>
</body>

</html>
