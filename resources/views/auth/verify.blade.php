@component('mail::message')
{{-- Greeting --}}
# @lang('verification.hello')!

{{ $email_verify_copy }}

@component('mail::button', ['url' => $url, 'color' => 'brand'])
    {{ $email_verify }}
@endcomponent

@lang('verification.regards'),<br>
{{ config('app.name') }}

{{-- Subcopy --}}
@slot('subcopy')
{{ $click_trouble }} <span class="break-all">{{ $url }}</span>
@endslot
@endcomponent
