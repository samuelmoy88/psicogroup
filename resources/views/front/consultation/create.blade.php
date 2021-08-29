<x-front-layout>
    <div class="main-min-height container mx-auto max-w-6xl p-5 gap-4">
        <h2 class="font-bold text-2xl mb-5">{{ __('common.appointment_request') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div class="col-span-1">
                <form action="{{ route('consultation.store') }}" method="POST">
                    <input type="hidden" name="specialist_profile_id" value="{{ $doctor->profile->id }}">
                    <input type="hidden" name="address_id" value="{{ $consultation->id }}">
                    @csrf
                    <div class="mb-5">
                        <p class="mb-3">Motivo de la cita</p>
                        @if(count($consultation->services) === 1)
                            <input type="hidden" name="service_id" value="{{ $consultation->services[0]->service_id }}">
                            <p class="pl-5">
                                {{ readServicesFromCache()->firstWhere('id', $consultation->services[0]->service_id)['title'] }}
                                @if($consultation->services[0]->price)
                                    - {{ $consultation->services[0]->price ? 'desde' : ''}} S/@money($consultation->services[0]->price)
                                @endif
                            </p>
                        @else
                            @foreach($consultation->services as $service)
                                <div>
                                    <label class="mb-1 cursor-pointer mr-2">
                                        <x-radio value="{{ $service->service_id }}"
                                                 name="service_id"/> {{ readServicesFromCache()->firstWhere('id', $service->service_id)['title'] }}
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-5">
                        <p class="mb-3">Información personal</p>
                        <div class="mb-4 text-sm w-full">
                            <x-label for="first_name">{{ __("common.first_name") }} *</x-label>
                            <x-input type="text" id="first_name" name="first_name"
                                 value="{{ auth()->check() ? auth()->user()->first_name : '' }}"/>
                        </div>
                        <div class="mb-4 text-sm w-full">
                            <x-label for="last_name">{{ __("common.last_names") }} *</x-label>
                            <x-input type="text" id="last_name" name="last_name"
                                     value="{{ auth()->check() ? auth()->user()->last_name : '' }}"/>
                        </div>
                    </div>
                    <div class="mb-5">
                        <p class="mb-3">Información de contacto</p>
                        <div class="mb-4 text-sm w-full">
                            <x-label for="email">{{ __("common.email") }} *</x-label>
                            <x-input type="text" id="email" name="email"
                                 value="{{ auth()->check() ? auth()->user()->email : '' }}"/>
                            <small>Recibiras un código en este email para confirmar la solicitud</small>
                        </div>
                        <div class="mb-4 text-sm w-full">
                            <x-label for="phone">{{ __("common.phone") }} *</x-label>
                            <x-input type="numeric" id="phone" name="phone"
                                     value="{{ auth()->check() ? auth()->user()->phone : '' }}"/>
                        </div>
                    </div>
                    <div class="mb-5">
                        <p class="mb-3">¿Es tu primera visita con este especialista? *</p>
                        <div>
                            <label class="mb-1 cursor-pointer mr-2">
                                <x-radio value="1" name="first_visit"/> {{__('common.yes')}}
                            </label>
                            <label class="mb-1 cursor-pointer mr-2">
                                <x-radio value="0" name="first_visit"/> {{__('common.no')}}
                            </label>
                            @error('first_visit')
                            <div class="text-red-500 mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <x-label for="comments">Observaciones para el especialista (opcional)</x-label>
                        <x-textarea name="comments" id="comments" rows="2"></x-textarea>
                    </div>
                    <div class="mb-5">
                        <label for="accept_legal" class="cursor-pointer">
                            <x-checkbox name="accept_legal" id="accept_legal" class="mr-1"/>
                            <span>Acepto las condiciones legales</span>
                        </label>
                        @error('accept_legal')
                        <div class="text-red-500 mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <x-button class="w-full justify-center">
                            {{ __('common.continue') }}
                        </x-button>
                    </div>
                </form>
            </div>
            <div class="col-span-1">

            </div>
        </div>
    </div>
</x-front-layout>
