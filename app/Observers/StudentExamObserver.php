<?php

namespace App\Observers;

use App\Models\StudentExam;

class StudentExamObserver
{
    public function creating(StudentExam $studentExam)
    {
        $studentExam->student_id = auth()->id();
    }

    public function saving(StudentExam $studentExam)
    {
        $studentExam->increment('attempts');
    }
}
