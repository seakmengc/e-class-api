<?php

namespace App\Listeners;

use App\Events\ClassUpdated;
use App\Mail\ClassUpdatedEmail;
use App\Models\StudentExam;
use App\Notifications\ClassUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{
    /**
     * Handle the event.
     *
     * @param  ClassUpdated  $event
     * @return void
     */
    public function handle(ClassUpdated $event)
    {
        $model = $event->model;

        $this->usersToNotify($model)->each(function ($user) use ($model) {
            $user->notify(new ClassUpdatedNotification($model, $model->wasRecentlyCreated));
        });
    }

    private function usersToNotify($model): Collection
    {
        if (get_class($model) === StudentExam::class)
            return collect([$model->student]);

        return $model->class->students;
    }
}
