@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Course Requests Management</h2>

    <!-- Add these buttons at the top -->
    <div class="mb-4">
        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#createGroupModal">
            Create Group
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enrollStudentModal">
            Enroll Student
        </button>
    </div>

    <!-- Create Group Modal -->
    <div class="modal fade" id="createGroupModal" tabindex="-1" aria-labelledby="createGroupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createGroupModalLabel">Create New Group</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createGroupForm">
                        <div class="mb-3">
                            <label for="course_id" class="form-label">Course</label>
                            <select class="form-select" id="course_id" required>
                                <!-- Populate with courses -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="group_name" class="form-label">Group Name</label>
                            <input type="text" class="form-control" id="group_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="max_students" class="form-label">Max Students</label>
                            <input type="number" class="form-control" id="max_students" required>
                        </div>
                        <div class="mb-3">
                            <label for="day_of_week" class="form-label">Day of Week</label>
                            <select class="form-select" id="day_of_week" required>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Saturday</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label">Time</label>
                            <input type="time" class="form-control" id="time" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createGroup()">Create Group</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enroll Student Modal -->
    <div class="modal fade" id="enrollStudentModal" tabindex="-1" aria-labelledby="enrollStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enrollStudentModalLabel">Enroll Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="enrollStudentForm">
                        <div class="mb-3">
                            <label for="student_id" class="form-label">Student</label>
                            <select class="form-select" id="student_id" required>
                                <!-- Populate with students -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="group_id" class="form-label">Group</label>
                            <select class="form-select" id="group_id" required>
                                <!-- Populate with groups -->
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="enrollStudent()">Enroll Student</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add your existing course requests table here -->
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch and populate form data
        fetch('/admin/get-form-data')
            .then(response => response.json())
            .then(data => {
                // Populate course dropdown
                const courseSelect = document.getElementById('course_id');
                data.courses.forEach(course => {
                    courseSelect.innerHTML += `
                        <option value="${course.id}">${course.name}</option>
                    `;
                });

                // Populate student dropdown
                const studentSelect = document.getElementById('student_id');
                data.students.forEach(student => {
                    studentSelect.innerHTML += `
                        <option value="${student.id}">${student.name} (${student.matric_number})</option>
                    `;
                });

                // Populate group dropdown
                const groupSelect = document.getElementById('group_id');
                data.groups.forEach(group => {
                    groupSelect.innerHTML += `
                        <option value="${group.id}">
                            ${group.course.name} - ${group.name}
                            (${group.day_of_week} ${group.time})
                        </option>
                    `;
                });
            })
            .catch(error => {
                console.error('Error loading form data:', error);
            });
    });

    function createGroup() {
    const courseId = document.getElementById('course_id').value;
    const groupName = document.getElementById('group_name').value;
    const maxStudents = document.getElementById('max_students').value;
    const dayOfWeek = document.getElementById('day_of_week').value;
    const time = document.getElementById('time').value;

    fetch('/admin/create-group', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            course_id: courseId,
            name: groupName,
            max_students: maxStudents,
            day_of_week: dayOfWeek,
            time: time
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Group created successfully!');
            $('#createGroupModal').modal('hide');
            // Optionally refresh the page or update the UI
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while creating the group');
    });
}

function enrollStudent() {
    const studentId = document.getElementById('student_id').value;
    const groupId = document.getElementById('group_id').value;

    fetch('/admin/enroll-student', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            student_id: studentId,
            group_id: groupId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Student enrolled successfully!');
            $('#enrollStudentModal').modal('hide');
            // Optionally refresh the page or update the UI
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while enrolling the student');
    });
}
</script>
@endpush
