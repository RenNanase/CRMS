<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-teal: #0d9488;
            --light-teal: #99f6e4;
            --dark-teal: #0f766e;
            --bg-light: #f0fdfa;
            --text-color: #334155;
            --sidebar-width: 280px;
            --topbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--text-color);
            background-color: var(--bg-light);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .top-navbar {
            background-color: white;
            padding: 0.8rem 1.5rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            height: var(--topbar-height);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .main-container {
            display: flex;
            flex: 1;
            margin-top: var(--topbar-height);
        }

        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--dark-teal) 0%, var(--primary-teal) 100%);
            position: fixed;
            top: var(--topbar-height);
            left: 0;
            height: calc(100vh - var(--topbar-height));
            overflow-y: auto;
            padding: 2rem 0;
            z-index: 900;
            transition: all 0.3s ease;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .sidebar h4 {
            color: white;
            font-size: 24px;
            font-weight: 600;
            padding: 0 1.5rem;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
            margin: 0.2rem 0;
        }

        .sidebar a i {
            margin-right: 1rem;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--light-teal);
        }

        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: var(--light-teal);
            font-weight: 500;
        }

        .nav-submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
            padding-left: 1rem;
            list-style: none;
        }

        .nav-submenu.show {
            max-height: 500px; /* Adjust this value based on your content */
            transition: max-height 0.3s ease-in;
        }

        .has-submenu {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .has-submenu .nav-text {
            flex: 1;
            margin-left: 1rem;  /* Space after the main icon */
        }

        .has-submenu .fa-chevron-down {
            font-size: 0.8rem;  /* Smaller icon size */
            margin-left: 0.5rem;  /* Space between text and arrow */
            transition: transform 0.3s ease;
        }

        /* Adjust for mobile view */
        @media (max-width: 992px) {
            .has-submenu .fa-chevron-down {
                position: absolute;
                right: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
            }

            .has-submenu.expanded .fa-chevron-down {
                transform: translateY(-50%) rotate(180deg);
            }
        }

        /* Adjust submenu items styling */
        .nav-submenu a {
            padding: 0.7rem 1.5rem;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Mobile responsive adjustments */
        @media (max-width: 992px) {
            .nav-submenu {
                padding-left: 0;
            }

            .nav-submenu a {
                padding: 0.7rem;
                justify-content: center;
            }

            .has-submenu .fa-chevron-down {
                right: 0.5rem;
            }
        }

        .content-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
            background-color: var(--bg-light);
            min-height: calc(100vh - var(--topbar-height));
            transition: all 0.3s ease;
        }

        .card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stats-card {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .stats-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-light);
            border-radius: 12px;
            color: var(--primary-teal);
            margin-top: auto;
        }

        .card-title {
            color: var(--text-color);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .stats-number {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark-teal);
            margin: 0;
            text-align: center;
        }

        .event-table {
            margin-top: 1rem;
        }

        .event-table thead th {
            background-color: var(--primary-teal);
            color: white;
            font-weight: 500;
            padding: 1rem;
            font-size: 0.95rem;
        }

        .event-table tbody td {
            padding: 1rem;
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .event-table tbody tr:nth-child(even) {
            background-color: var(--bg-light);
        }

.navbar-logo {
    height: 50px;
    width: auto;
    margin-right: 1rem;
    }

    .dashboard-header {
    background-color: white;
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    display: flex;
    justify-content: flex-end;
    align-items: center;
    }

    footer {
    padding: 1.5rem 2rem;
    background-color: white;
    color: var(--text-color);
    font-size: 0.9rem;
    box-shadow: 0 -2px 15px rgba(0,0,0,0.05);
    margin-top: auto;
    text-align: center;
    }

        @media (max-width: 992px) {
            :root {
                --sidebar-width: 80px;
            }

            .sidebar h4,
            .sidebar .nav-text {
                display: none;
            }

            .sidebar a {
                justify-content: center;
                padding: 1rem;
            }

            .sidebar a i {
                margin: 0;
                font-size: 1.3rem;
            }

            .nav-submenu {
                padding-left: 0;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }
        }

        .news-link h6 {
            color: var(--primary-teal);
            transition: color 0.2s ease;
            }

            .news-link:hover h6 {
            color: var(--dark-teal);
            }

            .modal-content {
            border: none;
            border-radius: 15px;
            }

            .modal-header {
            background-color: var(--bg-light);
            border-radius: 15px 15px 0 0;
            }

            .modal-body {
            padding: 2rem;
            }

            .modal-title {
            color: var(--dark-teal);
            font-weight: 600;
            }

            #newsContent {
            color: var(--text-color);
            line-height: 1.6;
            }

            .btn-close {
            background-color: var(--primary-teal);
            opacity: 0.5;
            transition: opacity 0.2s ease;
            }

            .btn-close:hover {
            opacity: 1;
            }
    </style>

</head>

<body>
    <nav class="top-navbar d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <button class="btn d-lg-none" id="sidebar-toggle">
                <i class="fas fa-bars"></i>
            </button>
            <img src="{{ asset('storage/logo/unissa_logo.png') }}" alt="UNISSA Logo" class="navbar-logo">
        </div>
        <div class="d-flex align-items-center">
            <span class="me-3">Welcome, {{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt me-1"></i> Logout
            </a>
        </div>
    </nav>

    <div class="main-container">
        <div class="sidebar">
            <h4>CRMS</h4>
            <a href="{{ route('admin.dashboard') }}" class="active">
                <i class="fas fa-home"></i>
                <span class="nav-text">Home</span>
            </a>
                <!-- User Management -->
<a href="#" class="nav-link has-submenu" data-target="user-submenu">
                <i class="fas fa-user-graduate"></i>
                <span class="nav-text">User Management</span>
                <i class="fas fa-chevron-down" style="color: rgba(255, 255, 255, 0.8);"></i>
            </a>
            <div class="nav-submenu" id="user-submenu">
<a href="{{ route('admin.students.index') }}">
                <i class="fas fa-user-graduate"></i>
                <span class="nav-text">Student Management</span>
            </a>
            <a href="{{ route('admin.lecturers.index') }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span class="nav-text">Lecturer Management</span>
            </a>
            </div>

<!-- Academic Management -->

<a href="#" class="nav-link has-submenu" data-target="academic-submenu">
    <i class="fas fa-user-graduate"></i>
    <span class="nav-text">Academic Management</span>
    <i class="fas fa-chevron-down" style="color: rgba(255, 255, 255, 0.8);"></i>
</a>
<div class="nav-submenu" id="academic-submenu">
    <a href="{{ route('admin.academic-periods.index') }}">
        <i class="fas fa-user-graduate"></i>
        <span class="nav-text">Academic Period</span>
    </a>
    <a href="{{ route('admin.registration-periods.index') }}">
        <i class="fas fa-chalkboard-teacher"></i>
        <span class="nav-text">Registration Period</span>
    </a>
    <a href="{{ route('courses.index') }}">
                    <i class="fas fa-book"></i>
                    <span class="nav-text">Course Management</span>
                </a>
<a href="{{ route('admin.program-structures.list') }}">
                <i class="fas fa-file-pdf"></i>
                <span class="nav-text">Program Structure Management</span>
            </a>
            <a href="{{ route('admin.groups.index') }}" class="nav-link">
                <i class="fas fa-users"></i>
                <span class="nav-text">Group Management</span>
            </a>
            <a href="{{ route('admin.timetables.show') }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span class="nav-text">Timetable Management</span>
                        </a>
</div>





            <a href="#" class="nav-link has-submenu" data-target="enrollment-submenu">
                <i class="fas fa-user-graduate"></i>
                <span class="nav-text">Enrollment Management</span>
                <i class="fas fa-chevron-down" style="color: rgba(255, 255, 255, 0.8);"></i>
            </a>
            <div class="nav-submenu" id="enrollment-submenu">
                <a href="{{ route('admin.course-requests.index') }}">
                    <i class="fas fa-check-circle"></i>
                    <span class="nav-text">Major Course Requests</span>
                </a>
            </div>

            <!-- Content Management -->
                        <a href="#" class="nav-link has-submenu" data-target="content-submenu">
                            <i class="fas fa-user-graduate"></i>
                            <span class="nav-text">Content Management</span>
                            <i class="fas fa-chevron-down" style="color: rgba(255, 255, 255, 0.8);"></i>
                        </a>
                        <div class="nav-submenu" id="content-submenu">
                            <a href="{{ route('events.index') }}">
                                <i class="fas fa-calendar-alt"></i>
                                <span class="nav-text">Event Management</span>
                            </a>
                            <a href="{{ route('news.index') }}">
                                <i class="fas fa-newspaper"></i>
                                <span class="nav-text">News Management</span>
                            </a>
                        </div>

        </div>

        <div class="content-wrapper">


            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="stats-info">
                            <h6 class="card-title">Total Students</h6>

                            <p class="stats-number">
                                @if(isset($totalStudents))
                                {{ $totalStudents }}
                                @else
                                <span class="text-muted">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="stats-info">
                            <h6 class="card-title">Total Lecturers</h6>
                            <p class="stats-number">{{ $totalLecturers ?? 0 }}</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card">
                        <div class="stats-info">
                            <h6 class="card-title">Total Courses</h6>
                            <p class="stats-number">{{ $totalCourses ?? 0 }}</p>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-book-open fa-2x"></i>
                        </div>
                    </div>
                </div>

<!-- Events -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-4">Upcoming Events</h5>
                            <div class="table-responsive">
                                <table class="table event-table">
                                    <thead>
                                        <tr>
                                            <th>Semester Name</th>
                                            <th>Event Type</th>
                                            <th>Event Title</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($events ?? [] as $event)
                                        <tr>
                                            <td>{{ $event->semester_name }}</td>
                                            <td>{{ $event->event_type }}</td>
                                            <td>{{ $event->event_title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No upcoming events found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



<!-- Latest News -->
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Latest News</h5>
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        @forelse($latestNews as $news)
                        <tr>
                            <td>
                                <a href="#" class="news-link text-decoration-none" data-bs-toggle="modal"
                                    data-bs-target="#newsModal" data-title="{{ $news->title }}"
                                    data-content="{{ $news->content }}"
                                    data-image="{{ $news->image ? asset('storage/' . $news->image) : '' }}">
                                    <h6 class="mb-1 text-teal-600 hover:text-teal-800">{{ $news->title }}</h6>
                                </a>
                                <small class="text-muted">
                                    Updated by {{ $news->user->name }} on {{ $news->updated_at->format('d M Y') }}
                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center">No news available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced News Modal -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-xl overflow-hidden">
            <div class="modal-header border-b border-teal-100 bg-teal-50/50 p-6">
                <h5 class="modal-title text-xl font-semibold text-teal-800" id="newsModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-6">
                <div id="newsImage" class="mb-6 text-center"></div>
                <div id="newsContent" class="prose max-w-none text-gray-700"></div>
            </div>
        </div>
    </div>
</div>







            </div>

        <footer>
            Developed by fxcknictnexoxo | © 2024 CRMS
        </footer>


    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // News Modal Handler
    document.addEventListener('DOMContentLoaded', function() {
        const newsModal = document.getElementById('newsModal');
        if (newsModal) {
            newsModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const title = button.getAttribute('data-title');
                const content = button.getAttribute('data-content');
                const image = button.getAttribute('data-image');

                const modalTitle = this.querySelector('.modal-title');
                const modalContent = this.querySelector('#newsContent');
                const modalImage = this.querySelector('#newsImage');

                modalTitle.textContent = title;
                modalContent.innerHTML = content;

                if (image) {
                    modalImage.innerHTML = `
                        <img src="${image}" alt="${title}"
                             class="img-fluid rounded"
                             style="max-height: 300px; width: auto;">
                    `;
                } else {
                    modalImage.innerHTML = '';
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const submenuTriggers = document.querySelectorAll('.has-submenu');

        submenuTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Toggle the expanded class for the arrow rotation
                this.classList.toggle('expanded');

                // Find and toggle the associated submenu
                const targetId = this.getAttribute('data-target');
                const submenu = document.getElementById(targetId);

                if (!submenu) {
                    console.error('Submenu not found:', targetId);
                    return;
                }

                // Close all other submenus
                document.querySelectorAll('.nav-submenu').forEach(menu => {
                    if (menu.id !== targetId) {
                        menu.classList.remove('show');
                        const otherTrigger = document.querySelector(`[data-target="${menu.id}"]`);
                        if (otherTrigger) {
                            otherTrigger.classList.remove('expanded');
                        }
                    }
                });

                // Toggle the current submenu
                submenu.classList.toggle('show');

                // Log for debugging
                console.log('Toggled submenu:', targetId, submenu.classList.contains('show'));
            });
        });
    });

</script>





</body>

</html
