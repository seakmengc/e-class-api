<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentAbsence;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentAbsencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user, $injected)
    {
        return $user->isATeacherOf($injected['class_id']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user, $injected)
    {
        return $user->isATeacherOf($injected['class_id']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  StudentAbsence  $studentAbsence
     * @return mixed
     */
    public function update(User $user, StudentAbsence $studentAbsence)
    {
        return $user->isATeacherOf($studentAbsence->classAttendance->class_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  StudentAbsence  $studentAbsence
     * @return mixed
     */
    public function delete(User $user, StudentAbsence $studentAbsence)
    {
        return $user->isATeacherOf($studentAbsence->classAttendance->class_id);
    }
}
