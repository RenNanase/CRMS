<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MajorCourseRegistration extends Model
{
    protected $table = 'major_course_registrations'; // Ensure this matches your database table name

    protected $fillable = [
        'student_id',
        'course_id',
        'status',
    ];

    // Define any relationships if necessary
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}