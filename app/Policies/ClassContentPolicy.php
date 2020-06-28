<?php

namespace App\Policies;

use App\Models\ClassContent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PhpParser\Node\Stmt\ClassConst;

class ClassContentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user, $injected)
    {
        return $user->isATeacherOf($injected['class_id']);
    }

    public function view(User $user, ClassContent $classContent)
    {
        return $user->isATeacherOf($classContent->class_id);
    }

    public function create(User $user, $injected)
    {
        return $user->isATeacherOf($injected['class_id']);
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
        return $user->isATeacherOf($classContent->class_id);
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
        return $user->isATeacherOf($classContent->class_id);
    }
}
