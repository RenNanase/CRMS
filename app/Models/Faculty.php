<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $fillable = ['faculty_name']; // Adjust based on your requirements

    public function lecturers()
    {
        return $this->hasMany(Lecturer::class, 'faculty_id'); // Update to faculty_id
    }

    public function programStructures()
    {
        return $this->hasMany(ProgramStructure::class, 'faculty_id');
    }
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

