<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentExam extends Model
{
    protected $fillable = ['student_id', 'exam_id', 'answer', 'point'];

    protected $casts = [
        'answer' => 'object',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class);
    }
}
