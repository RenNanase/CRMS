<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'course_id',
        'max_students',
        'day_of_week',
        'time',
        'place'
    ];
    protected $casts = [
        'time' => 'datetime:H:i',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    
    public function getCurrentEnrollmentCount()
    {
        return $this->enrollments()->count();
    }

    public function hasAvailableSpace()
    {
        return $this->getCurrentEnrollmentCount() < $this->max_students;
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function courseRequests()
    {
        return $this->hasMany(CourseRequest::class);
    }
    public function timetable()
    {
        return $this->hasOne(Timetable::class);
    }
}
