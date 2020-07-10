<?php

namespace App\Policies;

use App\Models\ClassContent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use PhpParser\Node\Stmt\ClassConst;

class ClassContentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ClassContent $classContent)
    {
        return $this->determine($user, $classContent->class_id);
    }

    public function create(User $user, $injected)
    {
        return $this->isATeacherOf($injected['class_id']);
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
        return $this->isATeacherOf($classContent->class_id);
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
        return $this->isATeacherOf($classContent->class_id);
    }

    public function determine(User $user, $classId)
    {
        return $user->isATeacherOf($classId) or $user->isAStudentIn($classId);
    }
}
