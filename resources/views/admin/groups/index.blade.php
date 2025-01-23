<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Group Management</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Navigation Buttons -->
        <div class="flex space-x-4 mb-4">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150">
                <i class="fas fa-home mr-2"></i>
                Dashboard
            </a>
            <button onclick="window.history.back()"
                class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition duration-150">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </button>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Header Section -->
            <div class="bg-teal-600 text-white px-6 py-4 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold">Group Management</h2>
                    <p class="text-teal-100">Manage your course groups and schedules</p>
                </div>
                <button type="button"
                    class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded transition duration-150"
                    data-bs-toggle="modal" data-bs-target="#createGroupModal">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create New Group
                </button>
            </div>

            <!-- Table Section -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-teal-50 border-b border-teal-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Course Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Course Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Group Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Day</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Place</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Capacity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-teal-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-teal-200">
                        @forelse($groups as $group)
                        <tr class="hover:bg-teal-50 transition duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{
                                $group->course->course_code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $group->course->course_name
                                }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $group->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $group->day_of_week }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ date('h:i A',
                                strtotime($group->time)) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $group->course->place }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <div class="flex-grow bg-teal-100 rounded-full h-2 max-w-[100px]">
                                        <div class="bg-teal-600 h-2 rounded-full"
                                            style="width: {{ ($group->enrollments_count / $group->max_students) * 100 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-600">
                                        {{ $group->enrollments_count }}/{{ $group->max_students }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button
                                    class="bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-md text-sm transition duration-150"
                                    onclick="deleteGroup({{ $group->id }})">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p>No groups found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Group Modal -->
        <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-lg shadow-xl">
                    <div class="modal-header bg-teal-600 text-white px-6 py-4 rounded-t-lg">
                        <h5 class="text-xl font-bold">Create New Group</h5>
                        <button type="button" class="text-white hover:text-teal-100" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body p-6">
                        <form id="createGroupForm" class="space-y-4">
                            <div>
                                <label for="course_id"
                                    class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    id="course_id" name="course_id" required>
                                    <option value="">Select Course</option>
                                </select>
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Group
                                    Name</label>
                                <input type="text"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    id="name" name="name" required>
                            </div>
                            <div>
                                <label for="max_students" class="block text-sm font-medium text-gray-700 mb-1">Maximum
                                    Students</label>
                                <input type="number"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    id="max_students" name="max_students" required min="1">
                            </div>
                            <div>
                                <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-1">Day of
                                    Week</label>
                                <select
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    id="day_of_week" name="day_of_week" required disabled>
                                    <option value="">Select Day</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Auto-filled based on course timetable</p>
                            </div>
                            <div>
                                <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Time</label>
                                <input type="time"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                                    id="time" name="time" required disabled>
                                <p class="mt-1 text-sm text-gray-500">Auto-filled based on course timetable</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-gray-50 px-6 py-4 rounded-b-lg">
                        <button type="button"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-150"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="button"
                            class="px-4 py-2 bg-teal-600 text-white rounded-md hover:bg-teal-700 transition duration-150"
                            onclick="createGroup()">Create Group</button>
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

        function showAlert(message, type = 'success') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: type,
                title: message
            });
        }

        function deleteGroup(groupId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d9488',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/groups/${groupId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Deleted!',
                                'Group has been deleted.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                data.message || 'Failed to delete group',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Failed to delete group',
                            'error'
                        );
                    });
                }
            });
        }

        function createGroup() {
            const courseSelect = document.getElementById('course_id');
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];

            if (!courseSelect.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Information',
                    text: 'Please select a course first!'
                });
                return;
            }

            const formData = {
                course_id: courseSelect.value,
                name: document.getElementById('name').value,
                max_students: document.getElementById('max_students').value,
                day_of_week: selectedOption.dataset.day,
                time: selectedOption.dataset.start,
            };

            // Show loading state
            Swal.fire({
                title: 'Creating group...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

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
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Group created successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        $('#createGroupModal').modal('hide');
                        document.getElementById('createGroupForm').reset();
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message || 'Failed to create group',
                        footer: 'Please check the information and try again'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to create group',
                    footer: 'Please try again later'
                });
            });
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

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all Bootstrap modals
            var myModalEl = document.getElementById('createGroupModal')
            var modal = new bootstrap.Modal(myModalEl)

            // Rest of your existing DOMContentLoaded code...
        });
    </script>
</body>

</html>
