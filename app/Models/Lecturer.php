<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'faculty_id',
        'phone',
        'course_id',
        'lecturer_id',
        'user_id',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_lecturer'); // Many-to-many relationship with Course
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'id'); // Update to faculty_id
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
