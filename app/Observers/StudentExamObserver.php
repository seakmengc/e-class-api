<?php

namespace App\Observers;

use App\Models\StudentExam;

class StudentExamObserver
{
    // public function creating(StudentExam $studentExam)
    // {
    //     $studentExam->student_id = auth()->id();
    //     $studentExam->attempts = 1;
    // }

    public function saving(StudentExam $studentExam)
    {
        if (isset($studentExam->attempts))
            $studentExam->increment('attempts');
        else
            $studentExam->attempts = 1;
    }
}
