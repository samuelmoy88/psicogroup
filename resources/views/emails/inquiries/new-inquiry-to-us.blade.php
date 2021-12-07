@component('mail::message')
# Hemos recibido una nueva solicitud, estos son los detalles:

Nombre: {{ $request['first_name'] }}

Apellidos: {{ $request['last_name'] }}

Email: {{ $request['email'] }}

Teléfono: {{ $request['phone'] }}

Plan premium: {{ $request['premium_plan'] }}

@if(isset($request['message']) && $request['message'])
Mensaje: {{ $request['message'] }}
@endif

@if(!is_null($user))
# Este usuario ya está registrado en {{ config('app.name') }}, este es su perfil
@component('mail::button', ['url' => $url])
Ver perfil
@endcomponent
@endif
@endcomponent
