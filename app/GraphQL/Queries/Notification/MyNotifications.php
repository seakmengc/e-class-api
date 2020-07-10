<?php

namespace App\GraphQL\Queries\Notification;

use App\Models\User;
use App\Models\Notification;

class MyNotifications
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        return Notification::where('notifiable_id', auth()->id())
            ->where('notifiable_type', User::class)
            ->latest()
            ->limit(10)
            ->get();
    }
}
