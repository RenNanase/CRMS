<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dean extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'office_location',
        'profile_picture',
        'faculty',
        'position',
        'staff_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
