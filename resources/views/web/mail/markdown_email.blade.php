@component('mail::message')
@foreach ($introLines as $item)
    {{ $item }}
@endforeach
@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
