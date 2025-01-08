@extends('layouts.app')
@section('content')

    <div class="container">
        <h2>Edit Student</h2>
        <form action="{{ route('students.edit', $student->id) }}" method="POST">
            @csrf
            @method('PUT')


            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="matric_number" class="form-label">Matric Number</label>
                        <input type="text" class="form-control" id="matric_number" name="matric_number" value="{{ $student->matric_number }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="programme" class="form-label">Programme</label>
                        <input type="text" class="form-control" id="programme" name="programme" value="{{ $student->programme }}" required>
                    </div>
                    <div class="mb-3">
            <label for="scholarship_status" class="form-label">Scholarship Status</label>
            <select name="is_scholarship" class="form-control">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="minor" class="form-label">Minor</label>
                        <input type="text" class="form-control" id="minor" name="minor" value="{{ $student->minor }}">
                    </div>
                    <div class="mb-3">
                        <label for="intake" class="form-label">Intake</label>
                        <input type="text" class="form-control" id="intake" name="intake" value="{{ $student->intake }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $student->phone }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ $student->address }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>


@endsection
