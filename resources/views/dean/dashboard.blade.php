<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dean Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .navbar-logo {
            height: 50px;
            width: auto;
            margin-right: 1rem;
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
            padding-left: 1rem;
            list-style: none;
        }

        .nav-submenu a {
            padding: 0.7rem 1.5rem;
            font-size: 0.9rem;
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
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

        footer {
            padding: 1.5rem 2rem;
            background-color: white;
            color: var(--text-color);
            font-size: 0.9rem;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.05);
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

            .btn-outline-teal {
                color: var(--primary-teal);
                border-color: var(--primary-teal);
            }

            .btn-outline-teal:hover {
                background-color: var(--primary-teal);
                color: white;
            }

            .bg-teal-50 {
                background-color: #f0fdfa;
            }

            .text-teal-700 {
                color: var(--dark-teal);
            }

            .text-teal-800 {
                color: #115e59;
            }

            .text-teal-500 {
                color: var(--primary-teal);
            }

            .pdf-preview-container {
                background: white;
                border-radius: 0.5rem;
                overflow: hidden;
            }
        }

        .btn-outline-teal {
            color: #0d9488;
            border-color: #0d9488;
        }

        .btn-outline-teal:hover {
            background-color: #0d9488;
            color: white;
        }

        .modal-xl {
            max-width: 90%;
        }

        /* Modal Styles */
        .modal-header {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            background-color: #0d9488;
            /* Changed to soft teal */
            padding: 1.5rem;
            text-align: center;
            /* Center the header content */
            display: flex;
            justify-content: center;
            /* Center the title */
            position: relative;
        }

        .modal-title {
            font-size: 1.25rem;
            color: #befffa;
            /* Darker teal for better contrast */
            margin: 0;
            font-weight: 600;
        }

        .btn-close {
            position: absolute;
            right: 1rem;
            padding: 1rem;
        }

        /* Content Styles */
        .news-content-wrapper {
            color: #1e293b;
            padding: 1rem;
        }

        .news-metadata {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        #newsContent {
            font-size: 1rem;
            line-height: 1.8;
            text-align: justify;
        }

        #newsContent p {
            margin-bottom: 1.5rem;
        }

        #newsImage {
            margin-bottom: 2rem;
        }

        #newsImage img {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Content Styles */
        .news-content-wrapper {
            color: #1e293b;
            /* Slate 800 */
        }

        #newsContent {
            font-size: 1rem;
            line-height: 1.7;
        }

        #newsContent p {
            margin-bottom: 1rem;
        }

        /* Metadata Styles */
        .news-metadata {
            color: #64748b;
            /* Slate 500 */
            font-size: 0.875rem;
        }

        .text-teal-600 {
            color: #0d9488;
        }

        /* Modal Animation */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .modal.fade.show .modal-dialog {
            transform: none;
        }

        /* Custom Scrollbar */
        .modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #99f6e4;
            border-radius: 4px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #99f6e4;
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
            <a href="{{ route('student.dashboard') }}" class="active">
                <i class="fas fa-home"></i>
                <span class="nav-text">Home</span>
            </a>
            <a href="{{ route('dean.profile.show') }}">
                <i class="fas fa-user"></i>
                <span class="nav-text">Profile</span>
            </a>
            <a href="#">
                <i class="fas fa-user-graduate"></i>
                <span class="nav-text">Course Registration</span>
            </a>
            <div class="nav-submenu">
                <a href="{{ route('dean.minor-requests.index') }}">
                    <i class="fas fa-file-alt"></i>
                    <span class="nav-text">Minor Course Requests</span>
                </a>
            </div>
        <!-- Faculty Management Section -->

                    </div>

        <div class="content-wrapper">
            <div class="row g-4">


                <!-- Upcoming Events Card -->
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
                                        @if($events && $events->isNotEmpty())
                                        @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event->semester_name }}</td>
                                            <td>{{ $event->event_type }}</td>
                                            <td>{{ $event->event_title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="5" class="text-center">No upcoming events found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Latest News Card -->
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
                                                <a href="#" class="news-link text-decoration-none"
                                                    data-bs-toggle="modal" data-bs-target="#newsModal"
                                                    data-title="{{ $news->title }}" data-content="{{ $news->content }}"
                                                    data-image="{{ $news->image ? asset('storage/' . $news->image) : '' }}"
                                                    data-updated-date="{{ $news->updated_at->format('d M Y') }}"
                                                    data-author="{{ $news->user->name }}">
                                                    <h6 class="mb-1 text-teal-600 hover:text-teal-800">{{ $news->title
                                                        }}</h6>
                                                </a>
                                                <small class="text-muted">
                                                    Updated by {{ $news->user->name }} on {{$news->updated_at->format('d
                                                    M Y') }}
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
            </div>
            <!-- News Modal -->
            <div class="modal fade" id="newsModal" tabindex="-1" aria-labelledby="newsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow-lg">
                        <!-- Modal Header with Teal Theme -->
                        <div class="modal-header bg-teal-600 text-white border-0">
                            <h5 class="modal-title" id="newsModalLabel" style="font-weight: 600;"></h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <!-- Modal Body with Styled Content -->
                        <div class="modal-body p-4">
                            <!-- Image Container -->
                            <div id="newsImage" class="mb-4 text-center">
                                <!-- Image will be inserted here -->
                            </div>

                            <!-- Content Container -->
                            <div class="news-content-wrapper">
                                <div class="news-metadata mb-3 text-muted">
                                    <small class="d-flex align-items-center">
                                        <i class="fas fa-calendar-alt me-2 text-teal-600"></i>
                                        <span id="newsDate"></span>
                                    </small>
                                </div>
                                <div id="newsContent" class="prose max-w-none">
                                    <!-- Content will be inserted here -->
                                </div>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer border-0 bg-gray-50">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        // Sidebar Toggle
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
const updatedDate = button.getAttribute('data-updated-date'); // Changed to updated-date
const author = button.getAttribute('data-author');

const modalTitle = this.querySelector('.modal-title');
const modalContent = this.querySelector('#newsContent');
const modalImage = this.querySelector('#newsImage');
const modalDate = this.querySelector('#newsDate');
const modalAuthor = this.querySelector('#newsAuthor');

// Set the title
modalTitle.textContent = title;

// Set the content
modalContent.innerHTML = content;

// Set the date and author
if (modalDate) {
modalDate.textContent = `Updated on ${updatedDate}`; // Added "Updated on"
}
if (modalAuthor) {
modalAuthor.textContent = `by ${author}`; // Added "by"
}

// Handle image
if (image && image !== '') {
modalImage.innerHTML = `
<div class="image-container position-relative overflow-hidden">
    <img src="${image}" alt="${title}" class="img-fluid shadow-sm rounded" style="max-height: 400px; width: auto;"
        onerror="this.parentElement.style.display='none'">
</div>
`;
} else {
modalImage.innerHTML = '';
}
});
}
});


    </script>


</body>

</html>

</html>
