<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'course_code',
        'course_name',
        'day_of_week',
        'start_time',
        'end_time',
        'place',
        'lecturer_id',
        'type',
        'course_id',
        'student_id',

    ];

    public $source;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
