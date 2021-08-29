@component('mail::message')
# Hola, {{ $consultation->first_name }}

Hemos enviado una solicitud de consulta a {{ $consultation->specialist->prefixLabel }} {{ $consultation->specialist->user->first_name }} {{ $consultation->specialist->user->last_name }}

En breve se pondrá en contacto contigo, a continuación te indicamos sus datos de contacto:

@if($consultation->specialist->user->email)
Email: {{ $consultation->specialist->user->email }}
@endif
@if($consultation->specialist->user->phone)
Teléfono: {{ $consultation->specialist->user->phone }}
@endif

# Equipo de {{ config('app.name') }}
@endcomponent
