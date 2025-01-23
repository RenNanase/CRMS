<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
    ];

    const ROLES = [
        'Admin' => 'Admin',
        'Student' => 'Student',
        'program_head' => 'program_head',
        'faculty_dean' => 'faculty_dean',
        'offering_faculty' => 'offering_faculty',
        'lecturer' => 'lecturer'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function hasRole($roles)
    {
        if (is_array($roles)) {
            return in_array($this->role, $roles);
        }

        return $this->role === $roles;
    }

    // In User.php
public function student()
{
    return $this->hasOne(Student::class);
}

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function lecturer()
    {
        return $this->hasOne(Lecturer::class, 'user_id');
    }

    public function AdminMiddleware()
    {
        return $this->role === 'admin';
    }
}
