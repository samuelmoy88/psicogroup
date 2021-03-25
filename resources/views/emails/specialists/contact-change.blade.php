@component('mail::message')
# Hola, {{ $user->first_name }}

{{ $body }}

# Equipo de {{ config('app.name') }}

@component('mail::button', ['url' => $url, 'color' => 'brand'])
Ver perfil
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
