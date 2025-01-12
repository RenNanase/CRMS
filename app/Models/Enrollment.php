<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'group_id',
        'course_id',
        'status'
    ];

    // Define relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Helper method to check for schedule conflicts
    public static function hasScheduleConflict($studentId, $groupId)
    {
        $newGroup = Group::find($groupId);

        return self::where('student_id', $studentId)
            ->whereHas('group', function ($query) use ($newGroup) {
                $query->where('day_of_week', $newGroup->day_of_week)
                    ->where('time', $newGroup->time);
            })->exists();
    }
}
