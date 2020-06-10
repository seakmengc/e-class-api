<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user)
    {
        $user->username = strtolower($user->username);
        $user->email = strtolower($user->email);

        if ($user->isDirty('password'))
            $user->password = bcrypt($user->password);
    }
}
