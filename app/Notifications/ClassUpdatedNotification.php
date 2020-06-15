<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClassUpdatedNotification extends Notification
{
    use Queueable;

    //either Exam or ClassContent or StudentExam
    public $model;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (object) [];
        $mail->content = $this->prepareContent();
        $mail->url = config('app.url');

        return (new MailMessage)
            ->subject('Class Notification')
            ->markdown('emails.classes.update', compact('mail'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'action' => $this->model->wasRecentlyCreated ? 'create' : 'update',
            'message' => $this->prepareContent(),
            'url' => config('app.url'),
        ];
    }

    private function prepareContent()
    {
        $objName = 'grade';
        switch (get_class($this->model)) {
            case Exam::class:
                $objName = 'exam';
                break;
            case ClassContent::class:
                $objName = 'content';
                break;
        }

        $action = 'a new';
        if (!$this->model->wasRecentlyCreated)
            $action = 'an updated';

        return "There is $action $objName {$this->model->name} in {$this->model->class->code}.";
    }
}
