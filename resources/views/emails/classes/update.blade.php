@component('mail::message')
# {{ config('app.name') }}

{{ $mail->content }}

@component('mail::button', ['url' => $mail->url])
More Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
