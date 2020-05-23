<?php

namespace App\Policies\Tests;

use App\Models\Tests\A;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Users\User;

class APolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if($user->can('Admin A'))
            return true;
    }

    public function viewAny(User $user)
    {
        return $this->determine($user, $a, 'ViewAny');
    }

    public function view(User $user, A $a)
    {
        return $this->determine($user, $a, 'View');
    }
    
    public function create(User $user)
    {
        return $this->determine($user, $a, 'Create');
    }

    public function update(User $user, A $a)
    {
        return $this->determine($user, $a, 'Update');
    }

    public function delete(User $user, A $a)
    {
        return $this->determine($user, $a, 'Delete');
    }

    public function restore(User $user, A $a)
    {
        return $this->determine($user, $a, 'Restore');
    }

    //Gate before will handle this case
    public function forceDelete(User $user, A $a)
    {
        return false;
    }

    private function determine(User $user, A $a, $action)
    {
        if ($user->can($action . ' Any A'))
            return true;

        if ($user->can($action . ' Own A'))
            return $user->id == $a->user_id;

        return false;
    }
}
