
{!! str_replace('[[USER]]', $author, env('EMAIL_DENIED_HEAD')) !!}
{!! str_replace('[[SUBMISSION_TITLE]]', $submission, env('EMAIL_DENIED_CONTENT')) !!}
{!! env('EMAIL_DENIED_FOOTER') !!}
