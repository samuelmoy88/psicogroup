@component('mail::message')
# Hola, {{ $user->first_name }}

{{ $clinic->first_name }} te ha invitado a ser parte de su equipo en {{ config('app.name') }}

Para aceptar solo tendrás que hacer clic en el siguiente botón

@component('mail::button', ['url' => $url_accept, 'color' => 'brand'])
Aceptar solicitud
@endcomponent

Por otra parte, si no deseas formar parte de {{ $clinic->first_name }}, haz clic en el siguiente botón

@component('mail::button', ['url' => $url_reject])
Rechazar solicitud
@endcomponent

# Equipo de {{ config('app.name') }}
@endcomponent
