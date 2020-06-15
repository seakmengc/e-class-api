<?php

namespace App\Listeners;

use App\Events\ClassUpdated;
use App\Mail\ClassUpdatedEmail;
use App\Models\StudentExam;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailNotification
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  ClassUpdated  $event
     * @return void
     */
    public function handle(ClassUpdated $event)
    {
        Mail::to($this->userEmailsInClass($event->model))
            ->sendNow(new ClassUpdatedEmail($event->model));
    }

    private function userEmailsInClass($model)
    {
        if (get_class($model) === StudentExam::class)
            return $model->student()->pluck('email')->first();

        return $model->class->students()->pluck('email')->toArray();
    }
}
