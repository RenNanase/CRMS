<!DOCTYPE html>
<html>
<head>
    <style>
        :root {
            --teal-primary: #00897b;
            --teal-light: #4ebaaa;
            --teal-dark: #005b4f;
            --gray-light: #f5f5f5;
            --gray-dark: #4a5568;
        }

        .event-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .nav-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            border-radius: 6px;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .nav-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            margin-right: 0.5rem;
        }

        .nav-btn-primary {
            background-color: var(--teal-primary);
        }

        .nav-btn-primary:hover {
            background-color: var(--teal-dark);
        }

        .nav-btn-secondary {
            background-color: var(--gray-dark);
        }

        .nav-btn-secondary:hover {
            background-color: #374151;
        }

        .event-title {
            color: var(--teal-dark);
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--teal-light);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: var(--teal-dark);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--teal-primary);
            box-shadow: 0 0 0 3px rgba(0, 137, 123, 0.1);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 500;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: var(--teal-primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--teal-dark);
        }

        .btn-secondary {
            background-color: #f5f5f5;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #e0e0e0;
        }

        .button-group {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .event-container {
                margin: 1rem;
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="event-container">
        <!-- Navigation Buttons -->
        <div class="nav-buttons">
            <a href="{{ route('admin.dashboard') }}" class="nav-btn nav-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Dashboard
            </a>
            <button onclick="window.history.back()" class="nav-btn nav-btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back
            </button>
        </div>
        
        <h2 class="event-title">Add New Event</h2>
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="semester_name" class="form-label">Semester Name</label>
                <input type="text" class="form-control" id="semester_name" name="semester_name" value="{{ $event->semester_name }}" required>
            </div>

            <div class="form-group">
                <label for="event_type" class="form-label">Event Type</label>
                <input type="text" class="form-control" id="event_type" name="event_type" value="{{ $event->event_type }}" required>
            </div>

            <div class="form-group">
                <label for="event_title" class="form-label">Event Title</label>
                <input type="text" class="form-control" id="event_title" name="event_title" value="{{ $event->event_title }}" required>
            </div>

            <div class="form-group">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $event->start_date }}" required>
            </div>

            <div class="form-group">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $event->end_date }}" required>
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Event</button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>