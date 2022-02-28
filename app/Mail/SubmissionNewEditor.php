<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmissionNewEditor extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($author, $submission)
    {
        $this->author     = $author->first_name. ' '. $author->last_name;
        $this->submission = $submission->title;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->view('emails.submission-new-editor',[
                    'author' => $this->author,
                    'submission' => $this->submission
                ])
            ->subject(env('EMAIL_NEW_SUBMISSION_EDITOR_SUBJECT'));
    }
}
