@component('mail::message')
# Hola, {{ $user->first_name }}

Bienvenido a {{ config('app.name') }}, a continuación te enviamos tus credenciales de acceso a nuestra aplicación.

Contraseña: {{ $password }}

@component('mail::button', ['url' => $url, 'color' => 'brand'])
Ver perfil
@endcomponent

# Equipo de {{ config('app.name') }}
@endcomponent
