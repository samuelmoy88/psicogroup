@component('mail::message')
# Hola, {{ $user->first_name }}

{{ $specialist->profile->prefixLabel }} {{ $specialist->fullName }} ha solicitado ser parte de tu centro médico en {{ config('app.name') }}

Para aceptar solo tendrás que hacer clic en el siguiente botón

@component('mail::button', ['url' => $url_accept, 'color' => 'brand'])
Aceptar solicitud
@endcomponent

Por otra parte, si no deseas que {{ $specialist->profile->prefixLabel }} {{ $specialist->fullName }} sea parte de tu equipo, haz clic en el siguiente botón

@component('mail::button', ['url' => $url_reject])
Rechazar solicitud
@endcomponent

# Equipo de {{ config('app.name') }}
@endcomponent
