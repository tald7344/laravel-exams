@component('mail::message')
# Introduction
Welcom {{ $data['data']->name }}
The body of your message.

@component('mail::button', ['url' => aurl('reset/password/' . $data['token']) ])
Reset Password
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
