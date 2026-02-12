<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'student_id',
        'term',
        'session',
        'days_present',
        'days_absent',
        'total_days',
    ];

    protected function casts(): array
    {
        return [
            'days_present' => 'integer',
            'days_absent' => 'integer',
            'total_days' => 'integer',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getAttendancePercentageAttribute()
    {
        if ($this->total_days == 0) return 0;
        return round(($this->days_present / $this->total_days) * 100, 2);
    }
}