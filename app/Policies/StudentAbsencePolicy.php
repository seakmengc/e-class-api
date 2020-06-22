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
    public function viewAny(User $user)
    {
        //
        if($user->isUser())
       {
         return false;
       }

       return true;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
         return $user->isTeacher();
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
        //
         return $user->isTeacher() && $user->isTeachingThis($user);
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
        //
         return $user->isTeacher() && $user->isTeachingThis($user);
    }


}
