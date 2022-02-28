
{!! str_replace('[[USER]]', $author, env('EMAIL_RESUBMIT_HEAD')) !!}
{!! str_replace('[[SUBMISSION_TITLE]]', $submission, env('EMAIL_RESUBMIT_CONTENT')) !!}
{!! env('EMAIL_RESUBMIT_FOOTER') !!}
