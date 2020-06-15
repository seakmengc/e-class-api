<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Notification $notification)
    {
        return $this->determine($user, $notification);
    }

    public function delete(User $user, Notification $notification)
    {
        return $this->determine($user, $notification);
    }

    private function determine(User $user, Notification $notification)
    {
        return $user->id == $notification->notifiable_id;
    }
}
