<?php

namespace App\Policies;

use App\Models\ClassContent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassContentPolicy
{
    use HandlesAuthorization;


    public function create(User $user)
    {
        //
        return $this->isTeacher();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClassContent  $classContent
     * @return mixed
     */
    public function update(User $user, ClassContent $classContent)
    {
        //
        return $user->isTeacher() && $user->isATeacherOf($classAttendance->class_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  ClassContent  $classContent
     * @return mixed
     */
    public function delete(User $user, ClassContent $classContent)
    {
        //
        return $user->isTeacher() && $user->isATeacherOf($classAttendance->class_id);
    }


}
