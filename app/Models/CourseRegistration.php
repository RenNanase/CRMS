<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student;
use App\Models\Course;
use App\Models\Group;

class CourseRegistration extends Model
{
    use HasFactory;

    protected $table = 'course_registrations'; // Assuming this is the table name

    protected $fillable = [
        'student_id',
        'course_id',
        'group_id',
        'status',
        'created_at',
        'updated_at',
    ];

    // Define relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
