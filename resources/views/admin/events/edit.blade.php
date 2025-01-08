<!DOCTYPE html>
<html>
<head>
    <style>
        :root {
            --teal-primary: #00897b;
            --teal-light: #4ebaaa;
            --teal-dark: #005b4f;
            --gray-light: #f5f5f5;
        }

        .event-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
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
        <h2 class="event-title">Edit Event</h2>
        <form action="{{ route('events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                <button type="submit" class="btn btn-primary">Update Event</button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>