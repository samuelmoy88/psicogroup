@component('mail::message')
# Hola, {{ $consultation->specialist->user->first_name }}

Has recibido una solicitud de consulta de {{ $consultation->first_name }} {{ $consultation->last_name }}

# Datos de contacto:

@if($consultation->email)
    Email: {{ $consultation->email }}
@endif
@if($consultation->phone)
    Teléfono: {{ $consultation->phone }}
@endif

# Datos de la solicitud:
Consulta: {{ $consultation->address->title }}
Servicio: {{ $consultation->service->title }}

Por favor, contacta con el paciente lo antes posible para concertar la cita.

# Equipo de {{ config('app.name') }}
@endcomponent
