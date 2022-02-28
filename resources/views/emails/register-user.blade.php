
{!! str_replace('[[USER]]', $user, env('EMAIL_REGISTER_USER_HEAD')) !!}
{!! env('EMAIL_REGISTER_USER_CONTENT') !!}
{!! env('EMAIL_REGISTER_USER_FOOTER') !!}
