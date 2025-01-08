<?php 


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['group_name','name', 'capacity', 'current_enrollment', 'course_id'];


    public function course()
    {
        return $this->hasMany(Course::class);
    }

    public static function allGroups()
{
    return self::all(); // This will return all records from the groups table
}
}