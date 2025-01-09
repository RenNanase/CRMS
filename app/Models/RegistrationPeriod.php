<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationPeriod extends Model
{
    protected $fillable = [
        'academic_period_id',
        'start_date',
        'end_date',
        'type'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    const TYPE_MAJOR = 'major';
    const TYPE_MINOR = 'minor';

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    public function scopeMajor($query)
    {
        return $query->where('type', 'major');
    }

    public function scopeMinor($query)
    {
        return $query->where('type', self::TYPE_MINOR);
    }

    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function isActive()
    {
        $now = now();
        return $now >= $this->start_date && $now <= $this->end_date;
    }
}
