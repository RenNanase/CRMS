<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRequest extends Model
{
    protected $table = 'course_requests';

    protected $fillable = [
        'student_id',
        'student_name',
        'course_id',
        'group_id',
        'course_code',
        'program',
        'matric_number',
        'request_type',
        'student_status',
        'fee_receipt',
        'status',
        'approved_at',
        'rejected_at',
        'comments',
        'submission_date',
        'prerequisite_check',
        'remarks',
        'registration_period_id',
        'group_name',
        'day_of_week',
        'time',
        'place',
    ];

    public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}

public function group()
{
    return $this->belongsTo(Group::class, 'group_id');
}

public function registrationPeriod()
{
    return $this->belongsTo(RegistrationPeriod::class, 'registration_period_id');
}
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
