<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinorRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'matric_number',
        'current_semester',
        'program_name',
        'phone',
        'email',
        'semester1_gpa',
        'semester2_gpa',
        'semester3_gpa',
        'semester4_gpa',
        'cgpa',
        'course_id',
        'course_code',
        'course_name',
        'faculty',
        'proposed_semester',
        'status',
        'remarks',
        'signed_form_path',  // Add this
        'recommendation_status',
        'dean_comments',
        'dean_name',
        'dean_signature',
        'recommendation_date'
    ];

    protected $casts = [
        'semester1_gpa' => 'decimal:2',
        'semester2_gpa' => 'decimal:2',
        'semester3_gpa' => 'decimal:2',
        'semester4_gpa' => 'decimal:2',
        'cgpa' => 'decimal:2',
    ];

    // If you're using enum for status, define the possible values
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELLED = 'cancelled';

    // Add this if you want to ensure status only accepts certain values
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $allowedStatuses = [
                self::STATUS_PENDING,
                self::STATUS_APPROVED,
                self::STATUS_REJECTED,
                self::STATUS_CANCELLED
            ];

            if (!in_array($model->status, $allowedStatuses)) {
                throw new \InvalidArgumentException('Invalid status value');
            }
        });
    }

    // Relationship with Student model
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relationship with Course model
    public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}

    // Scope for filtering by status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
