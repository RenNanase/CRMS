<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationPeriod extends Model
{
    protected $fillable = [
        'academic_period_id',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function isActive()
    {
        return $this->status === 'active' &&
            now()->between($this->start_date, $this->end_date);
    }
}
