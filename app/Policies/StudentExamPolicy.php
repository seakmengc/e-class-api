<?php

namespace App\Policies;

use App\Models\Classes;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentExamPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $injected)
    {
        $classId = Classes::findOrFail($injected['class_id'])->pluck('id')->first();

        return $user->isAStudentIn($classId);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentExam  $studentExam
     * @return mixed
     */
    public function view(User $user, StudentExam $studentExam)
    {
        $exam = $studentExam->exam;

        if ($user->isATeacherOf($exam->class_id))
            return true;

        return $user->isAStudentIn($exam->class_id)
            and $user->id === $studentExam->student_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $injected)
    {
        $exam = Exam::findOrFail($injected['exam_id']);

        return $user->isAStudentIn($exam->class_id);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\StudentExam  $studentExam
     * @return mixed
     */
    public function update(User $user, StudentExam $studentExam)
    {
        $exam = $studentExam->exam;

        return $user->isAStudentIn($exam->class_id)
            and $user->id === $studentExam->student_id;
    }

    public function grade(User $user, StudentExam $studentExam)
    {
        $classId = $studentExam->exam()->pluck('class_id')->first();

        return $user->isATeacherOf($classId);
    }

    public function determine(User $user, $classId)
    {
        return $user->isATeacherOf($classId) or $user->isAStudentIn($classId);
    }
}
