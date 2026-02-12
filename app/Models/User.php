<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isHeadmaster()
    {
        return $this->role === 'headmaster';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'teacher_id');
    }
}