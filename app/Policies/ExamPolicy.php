<?php

namespace App\Policies;

use App\Models\ClassCategory;
use App\Models\Exam;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user, $injected)
    {
        $classId = $injected['class_id'];

        return $this->determine($user, $classId);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exam  $exam
     * @return mixed
     */
    public function view(User $user, Exam $exam)
    {
        return $this->determine($user, $exam->class_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $injected)
    {
        $classId = ClassCategory::findOrFail($injected['class_category']['connect'])->pluck('class_id')->first();

        return $user->isATeacherOf($classId);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exam  $exam
     * @return mixed
     */
    public function update(User $user, Exam $exam)
    {
        return $user->isATeacherOf($exam->class_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Exam  $exam
     * @return mixed
     */
    public function delete(User $user, Exam $exam)
    {
        return $user->isATeacherOf($exam->class_id);
    }

    public function determine(User $user, $classId)
    {
        return $user->isATeacherOf($classId) or $user->isAStudentIn($classId);
    }
}
