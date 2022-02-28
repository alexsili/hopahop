
{!! env('EMAIL_NEW_SUBMISSION_EDITOR_HEAD') !!}
{!! str_replace(['[[USER]]', '[[SUBMISSION_TITLE]]'], [$author, $submission], env('EMAIL_NEW_SUBMISSION_EDITOR_CONTENT')) !!}
{!! env('EMAIL_NEW_SUBMISSION_EDITOR_FOOTER') !!}
