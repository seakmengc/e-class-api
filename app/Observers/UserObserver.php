<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user)
    {
        $user->username = strtolower($user->username);
        $user->email = strtolower($user->email);
        // if($user->password == '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
        $user->password = bcrypt($user->passsword);
    }
}
