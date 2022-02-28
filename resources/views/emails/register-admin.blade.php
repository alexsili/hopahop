
{!! env('EMAIL_REGISTER_ADMIN_HEAD') !!}

{!! str_replace(
    ['[[FIRST_NAME]]', '[[LAST_NAME]]', '[[AFFILIATION]]', '[[RESEARCH_FIELD]]', '[[COUNTRY]]'],
    [$user->first_name, $user->last_name, $user->affiliation, $user->research_field, $user->country->name],
    env('EMAIL_REGISTER_ADMIN_CONTENT')) !!}

{!! env('EMAIL_REGISTER_ADMIN_FOOTER') !!}
