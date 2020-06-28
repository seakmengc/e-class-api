<?php

namespace App\Policies;

use App\Models\ClassCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassCategoryPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
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
     * @param  ClassCategory  $classCategory
     * @return mixed
     */
    public function update(User $user, ClassCategory $classCategory)
    {
        return $user->isATeacherOf($classCategory->class_id);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  ClassCategory  $classCategory
     * @return mixed
     */
    public function delete(User $user, ClassCategory $classCategory)
    {
        //
        return $user->isATeacherOf($classCategory->class_id);
    }
}
