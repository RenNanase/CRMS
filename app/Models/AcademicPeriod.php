<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    protected $fillable = [
        'academic_year',
        'semester',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function registrationPeriod()
    {
        return $this->hasOne(RegistrationPeriod::class);
    }

    public function courseOfferings()
    {
        return $this->hasMany(CourseOffering::class);
    }
}
