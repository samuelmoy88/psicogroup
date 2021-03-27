@component('mail::message')
# Hola, {{ $user->first_name }}

{{ $body }}

@component('mail::button', ['url' => $url, 'color' => 'brand'])
Ver perfil
@endcomponent

Gracias,<br>
# Equipo de {{ config('app.name') }}
@endcomponent
