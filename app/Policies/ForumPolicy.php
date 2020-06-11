<?php

namespace App\Policies;

use App\Models\Forum;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
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
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function view(User $user, Forum $forum)
    {
        $classId = $forum->class_id;

        return $this->determine($user, $classId);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user, $injected)
    {
        $classId = $injected['class_id'];

        return $this->determine($user, $classId);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Forum  $forum
     * @return mixed
     */
    public function update(User $user, Forum $forum)
    {
        $classId = $forum->class_id;

        return $this->determine($user, $classId);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Forum  $forum
     * @return mixed
     */
    public function delete(User $user, Forum $forum)
    {
        $classId = $forum->class_id;

        return $this->determine($user, $classId);
    }

    public function determine(User $user, $classId)
    {
        return $user->isATeacherOf($classId) or $user->isAStudentIn($classId);
    }
}