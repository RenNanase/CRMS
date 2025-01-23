
    @extends('layouts.student')

    @section('title', 'Major Course Registration')

    @section('content')
    @if(!$activeMajorPeriod)
    <div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
        <div class="container mx-auto max-w-4xl p-8">
            <div class="text-center animate-fadeIn">
                <div class="mb-8 animate-float">
                    <svg class="mx-auto w-64 h-64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12 15V17M6 21H18C19.1046 21 20 20.1046 20 19V5C20 3.89543 19.1046 3 18 3H6C4.89543 3 4 3.89543 4 5V19C4 20.1046 4.89543 21 6 21ZM16 11H8V7H16V11Z"
                            stroke="#EF4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-4 animate-slideDown">
                    Registration Closed
                </h2>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-lg mb-6 animate-slideUp">
                    <p class="text-xl text-red-700 font-medium">
                        Major course registration is currently closed.
                    </p>
                    <p class="text-gray-600 mt-2">
                        Please check back during the next registration period.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mt-8 animate-fadeIn">
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Need Help?</h3>
                        <p class="text-gray-600">Contact your academic advisor for guidance</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Stay Updated</h3>
                        <p class="text-gray-600">Check the academic calendar for upcoming registration dates</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="min-h-screen bg-gradient-to-b from-teal-50 to-white py-8">
        <div class="container mx-auto max-w-4xl p-8 bg-white rounded-xl shadow-lg">
            <!-- Alert Messages -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-teal-100 border-l-4 border-teal-500 text-teal-700 rounded">
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                {{ session('error') }}
            </div>
            @endif

            <!-- Registration Form Container -->
            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-teal-800 text-center mb-8">Major Registration Form</h3>

                <form action="{{ route('course-requests.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}" />

                    <!-- Student Info Cards -->
                    <div class="grid md:grid-cols-2 gap-6 mb-8">
                        <div class="bg-teal-50 p-4 rounded-lg">
                            <label class="block text-sm font-semibold text-teal-700 mb-2">Student Status</label>
                            <p class="text-lg text-teal-900">{{ $student->scholarship_status }}</p>
                            <input type="hidden" name="student_status"
                                value="{{ strtolower($student->scholarship_status) }}" />
                        </div>

                        <div class="bg-teal-50 p-4 rounded-lg">
                            <label class="block text-sm font-semibold text-teal-700 mb-2">Matric Number</label>
                            <p class="text-lg text-teal-900">{{ $matricNumber }}</p>
                            <input type="hidden" name="matric_number" value="{{ $matricNumber }}" />
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-6">
                        <!-- Program Input Field -->
                        <div class="form-group">
                            <label for="program" class="block text-sm font-semibold text-teal-700 mb-2">Program</label>
                            <input type="text" name="program" id="program"
                                value="{{ $student->program->name ?? 'Not Assigned' }}"
                                class="w-full px-4 py-2 bg-gray-50 border border-teal-200 rounded-lg" readonly />
                        </div>

                        <!-- Request Type Field -->
                        <input type="hidden" name="request_type" value="major" />

                        <!-- Fee Receipt Section -->
                        <div id="fee-receipt" class="form-group">
                            <label for="fee_receipt" class="block text-sm font-semibold text-teal-700 mb-2">Upload Fee
                                Receipt @if(!$studentStatus)<span class="text-red-500">*</span>@endif</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="w-full flex flex-col items-center px-4 py-6 bg-teal-50 text-teal-700 rounded-lg tracking-wide border-2 border-dashed border-teal-200 cursor-pointer hover:bg-t[...]">
                                    <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                    </svg>
                                    <span class="mt-2 text-sm">Select a file</span>
                                    <input type="file" name="fee_receipt" id="fee_receipt" class="hidden"
                                        accept=".pdf,.jpg,.jpeg,.png" />
                                </label>
                            </div>
                            <p class="mt-2 text-sm text-gray-600">Accepted file types: PDF, JPG, JPEG, PNG</p>
                            @if(!$studentStatus)
                            <p class="mt-2 text-sm text-red-500">*Required for non-scholarship students</p>
                            <p id="fee-receipt-warning" class="mt-2 text-sm text-red-500 hidden">Please upload your fee receipt before submitting.</p>
                            @endif
                        </div>

                        <!-- Course Selection -->
                        <div class="form-group">
                            <label for="course" class="block text-sm font-semibold text-teal-700 mb-2">Select
                                Course</label>
                            <select name="course" id="course" required
                                class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200">
                                <option value="">-- Select a course --</option>
                                @if(isset($majorCourses) && $majorCourses->isNotEmpty())
                                @foreach($majorCourses as $course)
                                <option value="{{ $course->id }}" data-code="{{ $course->course_code }}" {{ $course->
                                    is_registered ? 'disabled' : '' }}
                                    class="{{ $course->request_status === 'approved' ? 'bg-gray-100 text-gray-500' : ''
                                    }}
                                    {{ $course->request_status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                    {{ $course->course_name }} ({{ $course->course_code }})
                                    {{ $course->status_message }}
                                </option>
                                @endforeach
                                @else
                                <option value="">No major courses available</option>
                                @endif
                            </select>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <span class="inline-block w-3 h-3 bg-gray-100 mr-1"></span> Already registered
                                    courses are disabled
                                </p>
                                <p class="text-sm text-gray-500">
                                    <span class="inline-block w-3 h-3 bg-yellow-100 mr-1"></span> Courses with pending
                                    requests are disabled
                                </p>
                            </div>
                        </div>

                        <!-- Add Group Selection (initially hidden) -->
                        <div id="group-selection" class="form-group mt-4" style="display: none;">
                            <label class="block text-sm font-semibold text-teal-700 mb-2">Available Groups</label>
                            <select name="group_id" id="group_id" required
                                class="w-full px-4 py-2 border border-teal-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition duration-200">
                                <option value="">-- Select a group --</option>
                            </select>

                            <!-- Group Details Card -->
                            <div id="group-details" class="mt-4 bg-teal-50 p-4 rounded-lg hidden">
                                <h4 class="text-sm font-semibold text-teal-700 mb-2">Group Details</h4>
                                <div class="space-y-2 text-sm text-teal-600">
                                    <p>Schedule: <span id="group-schedule"></span></p>
                                    <p>Location: <span id="group-location"></span></p>
                                    <p class="flex items-center">
                                        Capacity:
                                        <span id="group-capacity" class="ml-2"></span>
                                        <div class="ml-2 w-32 bg-teal-200 rounded-full h-2">
                                            <div id="capacity-bar" class="bg-teal-600 rounded-full h-2" style="width: 0%"></div>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="block text-sm font-semibold text-teal-700 mb-2">Course Code</label>
                            <input type="text" id="courseCode" name="course_code"
                                class="w-full px-4 py-2 bg-gray-50 border border-teal-200 rounded-lg" readonly />
                        </div>

                        <button type="submit"
                            class="w-full bg-teal-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-teal-700 focus:ring-4 focus:ring-teal-500 focus:ring-opacity-50 transition duration-200">
                            Submit Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseSelect = document.getElementById('course');
            if (courseSelect) {
                courseSelect.addEventListener('change', function() {
                    const courseId = this.value;
                    const selectedOption = this.options[this.selectedIndex];
                    const courseCodeInput = document.getElementById('courseCode');
                    const groupSelection = document.getElementById('group-selection');
                    const groupDetails = document.getElementById('group-details');

                    // Set course code immediately from the data attribute
                    courseCodeInput.value = selectedOption.getAttribute('data-code');

                    if (!courseId) {
                        groupSelection.style.display = 'none';
                        groupDetails.classList.add('hidden');
                        return;
                    }

                    // Show group selection and fetch groups
                    groupSelection.style.display = 'block';
                    fetchGroups(courseId);
                });
            }

            // Group select change event - keep existing group details functionality
            const groupSelect = document.getElementById('group_id');
            if (groupSelect) {
                groupSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const groupDetails = document.getElementById('group-details');

                    if (!this.value) {
                        groupDetails.classList.add('hidden');
                        return;
                    }

                    // Show group details
                    groupDetails.classList.remove('hidden');

                    // Update details
                    document.getElementById('group-schedule').textContent =
                        `${selectedOption.dataset.day} at ${selectedOption.dataset.time}`;
                    document.getElementById('group-location').textContent =
                        selectedOption.dataset.location;

                    const enrolled = parseInt(selectedOption.dataset.enrolled);
                    const capacity = parseInt(selectedOption.dataset.capacity);
                    document.getElementById('group-capacity').textContent =
                        `${enrolled}/${capacity} students`;

                    // Update capacity bar
                    const percentage = (enrolled / capacity) * 100;
                    document.getElementById('capacity-bar').style.width = `${percentage}%`;
                });
            }

            function fetchGroups(courseId) {
                if (!courseId) return;

                console.log('Fetching groups for course:', courseId);

                fetch(`/groups/course/${courseId}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Received groups data:', data);
                        const groupSelect = document.getElementById('group_id');
                        groupSelect.innerHTML = '<option value="">-- Select a group --</option>';

                        if (data.success && data.groups && data.groups.length > 0) {
                            data.groups.forEach(group => {
                                const option = document.createElement('option');
                                option.value = group.id;
                                option.dataset.day = group.day_of_week;
                                option.dataset.time = group.time;
                                option.dataset.location = group.place;
                                option.dataset.capacity = group.max_students;
                                option.dataset.enrolled = group.current_students;
                                option.textContent = `Group ${group.name} (${group.current_students}/${group.max_students} students)`;

                                if (group.is_full) {
                                    option.disabled = true;
                                    option.textContent += ' (FULL)';
                                }

                                groupSelect.appendChild(option);
                            });
                        } else {
                            groupSelect.innerHTML += '<option disabled>No groups available for this course</option>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching groups:', error);
                        const groupSelect = document.getElementById('group_id');
                        groupSelect.innerHTML = '<option value="">Error loading groups</option>';
                    });
            }

            // Fee Receipt Handling
            const studentStatus = {{ $studentStatus ? 'true' : 'false' }};
            const feeReceiptInput = document.getElementById('fee_receipt');
            const submitButton = document.querySelector('button[type="submit"]');
            const warningMessage = document.getElementById('fee-receipt-warning');
            const form = document.querySelector('form');

            // File upload preview
            if (feeReceiptInput) {
                feeReceiptInput.addEventListener('change', function(e) {
                    const fileName = e.target.files[0]?.name;
                    if (fileName) {
                        const fileLabel = this.previousElementSibling;
                        fileLabel.textContent = fileName;
                        warningMessage.classList.add('hidden');
                    }
                });
            }

            // Form submission validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!studentStatus) {
                        if (!feeReceiptInput || !feeReceiptInput.files.length) {
                            e.preventDefault();
                            e.stopPropagation();
                            warningMessage.classList.remove('hidden');
                            // Scroll to the warning message
                            warningMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            return false;
                        }
                    }
                });
            }

            // Remove the required attribute from hidden input
            if (feeReceiptInput && !studentStatus) {
                // Remove required attribute but keep validation in JavaScript
                feeReceiptInput.removeAttribute('required');
            }
       // Initialize Echo
            window.Echo = new Echo({
            broadcaster: 'pusher',
            key: process.env.MIX_PUSHER_APP_KEY,
            cluster: process.env.MIX_PUSHER_APP_CLUSTER,
            forceTLS: true
            });

            // Listen for enrollment updates
            Echo.channel('enrollments')
            .listen('EnrollmentUpdated', (e) => {
            updateGroupCapacity(e.groupId, e.currentCount, e.maxStudents);
            });

            function updateGroupCapacity(groupId, currentCount, maxStudents) {
            // Update select option
            const groupSelect = document.getElementById('group_id');
            const option = groupSelect.querySelector(`option[value="${groupId}"]`);
            if (option) {
            option.dataset.enrolled = currentCount;
            option.dataset.capacity = maxStudents;
            option.textContent = `Group ${option.dataset.name} (${currentCount}/${maxStudents} students)`;

            // Disable if full
            if (currentCount >= maxStudents) {
            option.disabled = true;
            option.textContent += ' (FULL)';
            } else {
            option.disabled = false;
            }
            }

            // Update group details if currently selected
            if (groupSelect.value === groupId.toString()) {
            const capacityText = document.getElementById('group-capacity');
            const capacityBar = document.getElementById('capacity-bar');
            if (capacityText && capacityBar) {
            capacityText.textContent = `${currentCount}/${maxStudents} students`;
            const percentage = (currentCount / maxStudents) * 100;
            capacityBar.style.width = `${percentage}%`;
            }
            }
            }
            });
    </script>
    @endif
    @endsection
