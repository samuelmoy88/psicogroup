@component('mail::message')
# Hola, {{ $request['first_name'] }}

Hemos recibido tu solicitud de contacto. Pronto nuestro equipo se pondrá en contacto contigo para atender tu solicitud.

Gracias y un saludo!

# Equipo de {{ config('app.name') }}
@endcomponent
