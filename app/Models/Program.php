<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'code',
        'faculty_id',
        'description',


    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function programStructures()
    {
        return $this->hasMany(ProgramStructure::class);
    }


    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
