<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CourseRegistration;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'matric_number',
        'ic_number',
        'current_semester',
        'phone',
        'academic_year',
        'phone',
        'address',
        'user_id',
        'scholarship_status',
        'program_id',
        'photo',
        'faculty_id',
    ];

    // Accessor for is_scholarship
    public function getIsScholarshipAttribute($value)
    {
        return $value == 1; // Assuming 1 means scholarship, adjust as necessary
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function enrolledCourses()
    {
        return $this->hasMany(CourseRegistration::class, 'student_id');
    }

    public function minorRegistrations()
    {
        return $this->hasMany(MinorRegistration::class);
    }

    public function programStructure()
    {
        return $this->belongsTo(ProgramStructure::class, 'program_id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'enrollments');
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student')
        ->withPivot(['status', 'group_id', 'semester', 'academic_year'])
        ->withTimestamps();
    }
    public function enrollInCourse(Course $course, $semester, $academicYear)
    {
        return $this->courses()->attach($course->id, [
            'status' => 'enrolled',
            'semester' => $semester,
            'academic_year' => $academicYear
        ]);
    }
    public function dropCourse(Course $course)
    {
        return $this->courses()->updateExistingPivot($course->id, [
            'status' => 'dropped'
        ]);
    }
}
