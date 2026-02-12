<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TermResult extends Model
{
    protected $fillable = [
        'student_id',
        'term',
        'session',
        'total_score',
        'average_score',
        'gpa',
        'position',
        'headmaster_remark',
        'teacher_remark',
        'is_approved',
        'approved_at',
        'approved_by',
        'is_backed_up',
        'backed_up_at',
    ];

    protected function casts(): array
    {
        return [
            'total_score' => 'decimal:2',
            'average_score' => 'decimal:2',
            'gpa' => 'decimal:2',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
            'is_backed_up' => 'boolean',
            'backed_up_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}