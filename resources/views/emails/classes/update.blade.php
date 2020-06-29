@component('mail::message')
# Dear, {{ $mail->name }}

{{ $mail->content }}

@component('mail::button', ['url' => $mail->url])
Detail
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
