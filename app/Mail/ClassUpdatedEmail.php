<?php

namespace App\Mail;

use App\Models\ClassContent;
use App\Models\Exam;
use App\Models\StudentExam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Stmt\ClassConst;

class ClassUpdatedEmail extends Mailable
{
    use Queueable, SerializesModels;

    //either Exam or ClassContent or StudentExam
    public $model;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = (object) [];
        $mail->content = $this->prepareContent();
        $mail->url = config('app.url');

        return $this->subject('Class Notification')
            ->markdown('emails.classes.update', compact('mail'));
    }

    private function prepareContent()
    {
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
        }

        $action = 'a new';
        if (!$this->model->wasRecentlyCreated)
            $action = 'an updated';

        return "There is $action $objName {$this->model->name} in {$this->model->class->code}.";
    }
}
