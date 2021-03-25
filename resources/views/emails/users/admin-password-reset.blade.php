@component('mail::message')
# Hola, {{ $user->first_name }}

Esta es tu nueva contraseña: {{ $password }}

@component('mail::button', ['url' => $url, 'color' => 'brand'])
    Ver perfil
@endcomponent

# Equipo de {{ config('app.name') }}
@endcomponent
