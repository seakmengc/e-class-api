<?php

namespace App\Observers;

use App\Models\StudentExam;

class StudentExamObserver
{
    public function creating(StudentExam $studentExam)
    {
        $studentExam->student_id = auth()->id();
        $studentExam->attempts = 1;
    }

    public function updating(StudentExam $studentExam)
    {
        $studentExam->increment('attempts');
    }
}
