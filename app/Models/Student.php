<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'admission_number',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'date_of_birth',
        'class',
        'section',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function termResults()
    {
        return $this->hasMany(TermResult::class);
    }
}