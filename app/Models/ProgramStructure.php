<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'faculty_id',
        'program_id',
        'pdf_path',
        'academic_year',
        'version',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with Faculty
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    // Relationship with Students
    public function students()
    {
        return $this->hasMany(Student::class, 'program_id');
    }

    // Scope to get active program structures
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope to get latest version
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
