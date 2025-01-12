@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Enroll Student</h2>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.enroll-student.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="student_id" class="form-label">Student</label>
                    <select class="form-select" id="student_id" name="student_id" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->matric_number }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="group_id" class="form-label">Group</label>
                    <select class="form-select" id="group_id" name="group_id" required>
                        <option value="">Select Group</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}">
                            {{ $group->course->name }} - {{ $group->name }}
                            ({{ $group->day_of_week }} {{ $group->time }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Enroll Student</button>
            </form>
        </div>
    </div>
</div>
@endsection
