<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_name',
        'course_code',
        'credit_hours',
        'faculty',
        'capacity',
        'prerequisite_id',
        'faculty_id',
        'type' //major or minor
    ];
    public function group()
    {
        return $this->belongsTo(Group::class);
    }


    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function prerequisites()
    {
        Log::info('Fetching prerequisites for course ID: ' . $this->id);
        $prerequisites = $this->belongsToMany(Course::class, 'course_prerequisite', 'course_id', 'prerequisite_id');
        Log::info('Prerequisites method executed successfully for course ID: ' . $this->id);
        return $this->belongsToMany(Course::class, 'course_prerequisite', 'course_id', 'prerequisite_id');
    }

    public function timetables()
{
    return $this->hasMany(Timetable::class);
}

public function lecturers()
{
    return $this->belongsToMany(Lecturer::class, 'course_lecturer'); // Many-to-many relationship with Lecturer
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}
    public function timetable()
    {
        return $this->hasOne(Timetable::class);
    }
}
