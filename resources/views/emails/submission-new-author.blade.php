
{!! str_replace('[[USER]]', $author, env('EMAIL_NEW_SUBMISSION_AUTHOR_HEAD')) !!}
{!! str_replace('[[SUBMISSION_TITLE]]', $submission, env('EMAIL_NEW_SUBMISSION_AUTHOR_CONTENT')) !!}
{!! env('EMAIL_NEW_SUBMISSION_AUTHOR_FOOTER') !!}
