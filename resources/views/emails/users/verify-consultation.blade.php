@component('mail::message')
# Hola, {{ $user['first_name'] }}

Hemos recibido tu solicitud de consulta.

Código: {{ $token }}

Este código será válido durante los próximos 10 minutos.

# Equipo de {{ config('app.name') }}
@endcomponent
