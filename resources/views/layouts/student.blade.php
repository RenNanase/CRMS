<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard')</title>
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
            <a href="{{ route('students.profile', ['id' => Auth::id()]) }}">
                <i class="fas fa-user"></i>
                <span class="nav-text">My Profile</span>
            </a>
            <a href="#">
                <i class="fas fa-user-graduate"></i>
                <span class="nav-text">Course Registration</span>
            </a>
            <div class="nav-submenu">
                <a href="{{ route('student.major-registration') }}">
                    <i class="fas fa-check-circle"></i>
                    <span class="nav-text">Apply Major Courses</span>
                </a>
                <a href="{{ route('student.minor-registration.create', ['id' => $student->id]) }}">
                    <i class="fas fa-check-circle"></i>
                    <span class="nav-text">Apply Minor Courses</span>
                </a>
                <a href="{{ route('students.status-enrollment', ['id' => $student->id]) }}">
                    <i class="fas fa-check-circle"></i>
                    <span class="nav-text">Enrollment Status</span>
                </a>
            </div>
            <a href="{{ route('student.timetable', ['id' => $student->id]) }}">
                <i class="fas fa-calendar"></i>
                <span class="nav-text">Timetable</span>
            </a>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')

            <footer>
                Developed by fxcknictnexoxo | © 2024 CRMS
            </footer>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    @stack('scripts')
</body>
</html>
