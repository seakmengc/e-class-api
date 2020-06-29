<?php

namespace App\Notifications;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Log;

class ClassUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    //either Exam or ClassContent or StudentExam
    public $model;
    public $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $wasRecentlyCreated)
    {
        $this->model = $model;
        $this->action = $wasRecentlyCreated ? 'a new' : 'an updated';
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
        $mail->name = $notifiable->identity->first_name;

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
            'action' => $this->action === 'a new' ? 'created' : 'updated',
            'message' => $this->prepareContent(),
            'url' => config('app.url'),
        ];
    }

    private function prepareContent()
    {
        $objName = '';
        switch (get_class($this->model)) {
            case Exam::class:
                $objName = 'exam';
                break;
            case ClassContent::class:
                $objName = 'content';
                break;
            case StudentExam::class:
                $objName = 'grade';
                break;
            default:
                break;
        }

        return "There is {$this->action} $objName \"{$this->model->name}\" in \"{$this->model->class->code}\".";
    }
}
