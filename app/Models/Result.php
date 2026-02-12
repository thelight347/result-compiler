<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'teacher_id',
        'term',
        'session',
        'ca1_score',
        'ca2_score',
        'ca3_score',
        'exam_score',
        'total_score',
        'grade',
        'remark',
        'is_released',
        'is_locked',
        'released_at',
        'locked_at',
    ];

    protected function casts(): array
    {
        return [
            'ca1_score' => 'decimal:2',
            'ca2_score' => 'decimal:2',
            'ca3_score' => 'decimal:2',
            'exam_score' => 'decimal:2',
            'total_score' => 'decimal:2',
            'is_released' => 'boolean',
            'is_locked' => 'boolean',
            'released_at' => 'datetime',
            'locked_at' => 'datetime',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function calculateTotal()
    {
        $this->total_score = $this->ca1_score + $this->ca2_score + $this->ca3_score + $this->exam_score;
        return $this->total_score;
    }

    public function calculateGrade()
    {
        $total = $this->total_score;
        
        if ($total >= 90) {
            $this->grade = 'A+';
            $this->remark = 'Excellent';
        } elseif ($total >= 80) {
            $this->grade = 'A';
            $this->remark = 'Very Good';
        } elseif ($total >= 70) {
            $this->grade = 'B';
            $this->remark = 'Good';
        } elseif ($total >= 60) {
            $this->grade = 'C';
            $this->remark = 'Credit';
        } elseif ($total >= 50) {
            $this->grade = 'D';
            $this->remark = 'Pass';
        } else {
            $this->grade = 'F';
            $this->remark = 'Fail';
        }

        return $this->grade;
    }
}