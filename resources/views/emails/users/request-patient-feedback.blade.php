@component('mail::message')
# Hola, {{ $consultation->patient->user->first_name }}

Nos complace saber que tu solicitud de cita con {{ $consultation->specialist->prefixLabel }} {{ $consultation->specialist->user->first_name }} {{ $consultation->specialist->user->last_name }} ya ha sido efectuada.

A continuación te enviamos un enlace para que nos des feedback

@component('mail::button', ['url' => $url, 'color' => 'brand'])
    Dar feedback
@endcomponent

# Equipo de {{ config('app.name') }}
@endcomponent
