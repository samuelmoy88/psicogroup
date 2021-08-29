@component('mail::message')
# Hola, {{ $rating->patient->user->first_name }}

A continuación te enviamos un enlace para que modifiques tu valoración del profesional {{ $rating->specialist->prefixLabel }} {{ $rating->specialist->user->first_name }} {{ $rating->specialist->user->last_name }}

@component('mail::button', ['url' => $url, 'color' => 'brand'])
    Modificar valoración
@endcomponent

# Equipo de {{ config('app.name') }}
@endcomponent
