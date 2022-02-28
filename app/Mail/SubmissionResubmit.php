<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionResubmit extends Mailable
{
    use Queueable, SerializesModels;

    public $author;
    public $submission;

    public function __construct($author, $submission)
    {
        $this->author     = $author->first_name. ' '. $author->last_name;
        $this->submission = $submission->title;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('emails.submission-resubmit',[
                    'author' => $this->author,
                    'submission' => $this->submission
                ])
            ->subject(env('EMAIL_RESUBMIT_SUBJECT'));
    }
}
