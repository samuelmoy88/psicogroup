<x-app-layout>
    <form action="{{ route('specialist.addresses.update', ['specialist' => auth()->user()->username, 'address' => $address->id]) }}" method="post" id="edit_address">
        @csrf
        @method('PUT')
        <div class="form-card">
            <h2 class="font-bold text-xl">
                {{ $address->consultation_type == 'physical' ? __('address.edit_physical') : __('address.edit_online') }}
            </h2>
        </div>

        <div class="form-card" x-data="">
            <h2 class="font-bold text-xl">{{ __('address.where') }}</h2>
            <div class="mt-4 mb-4 text-sm">
                <label class="mb-1 cursor-pointer mr-2">
                    <x-radio checked="{{ $address->is_private == '1' ? true : false }}" value="1" name="is_private"/> {{__('address.private')}}
                </label>
                <label class="mb-1 cursor-pointer mr-2">
                    <x-radio checked="{{ $address->is_private == '0' ? true : false }}" value="0" name="is_private"/> {{__('address.medical')}}
                </label>
            </div>
            <div class="flex flex-wrap">
                <div class="mb-4 text-sm w-full">
                    <x-label for="title">{{ __("Consulting room's name") }} *</x-label>
                    <x-input type="text" value="{{ $address->title }}" id="title" name="title"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4 relative">
                    <input type="hidden" name="latitude" id="latitude" value="{{ $address->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $address->longitude }}">
                    <x-label for="street">{{ __("Street") }} *</x-label>
                    <x-input type="text" value="{{ $address->street }}" id="street" name="street"/>
                    <div id="street-results" class="absolute w-half hidden geo-coder-results"></div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4">
                    <x-label for="city">{{ __("City") }} *</x-label>
                    <x-input type="text" value="{{ $address->city }}" id="city" name="city"/>
                    <div id="city-results" class="absolute w-full hidden geo-coder-results"></div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                    <x-label for="zip_code">{{ __("Zip code") }} *</x-label>
                    <x-input type="text" value="{{ $address->zip_code }}" id="zip_code" name="zip_code"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4">
                    <x-label for="web_site">{{ __("Web site") }}</x-label>
                    <x-input type="text" value="{{ $address->web_site }}" id="web_site" name="web_site"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4">
                    <x-label for="main_phone">{{ __("Main phone") }}</x-label>
                    <x-input type="tel" value="{{ $address->main_phone }}" id="main_phone" name="main_phone"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                    <x-label for="secondary_phone">{{ __("Secondary phone") }}</x-label>
                    <x-input type="tel" value="{{ $address->secondary_phone }}" id="secondary_phone" name="secondary_phone"/>
                </div>

                <div class="mb-4 text-sm">
                    <x-label class="mb-2">{{ __("Accessibility for pacients with impaired mobility") }}</x-label>
                    @foreach($addressAccessibility as $accessibility)
                        <label class="flex items-center mb-2 cursor-pointer">
                            <input type="hidden" name="accessibility[{{ $accessibility->id }}]" value="0">
                            <x-checkbox checked="{{ $address->accessibility->contains($accessibility->id) ? true : false }}" name="accessibility[{{ $accessibility->id }}]" value="1"/>
                            <span class="ml-2">{{ $accessibility->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('Indications to arrive') }}</h2>
            <p class="text-bold text-black">Información que los pacientes recibirán tras agendar cita y que les ayudará
                a encontrar su consulta más fácilmente. P. ej. cómo acceder al edificio de entrada, cómo llegar con
                transporte público, etc.</p>
            <div class="my-4 text-sm">
                <x-textarea name="address_indications" id="address_indications">{{ $address->address_indications }}</x-textarea>
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('Payment methods') }}</h2>
            <div class="mb-4 text-sm flex">
                @foreach($paymentMethods as $key => $paymentMethod)
                    @if($key == 0 || round(count($paymentMethods) / 2) == $key )
                        <div class="w-full md:w-1/2">
                            @endif
                            <label class="flex items-center mb-2 cursor-pointer">
                                <input type="hidden" name="paymentMethods[{{ $paymentMethod->id }}]" value="0">
                                <x-checkbox checked="{{ $address->paymentMethods->contains($paymentMethod->id) ? true : false }}" name="paymentMethods[{{ $paymentMethod->id }}]" value="1"/>
                                <span class="ml-2">{{ $paymentMethod->title }}</span>
                            </label>
                            @if($key == (count($paymentMethods) - 1) || round(count($paymentMethods) / 2) == ($key + 1))
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('Other information') }}</h2>
            {{--<div class="mt-4 mb-4 text-sm">
                <x-label class="mb-2 font-bold">{{ __('I attend to') }}</x-label>
                @foreach($insuranceSupport as $insurance)
                    <label class="flex items-center mb-2 cursor-pointer">
                        <input type="radio" name="insurance_support_id" value="{{ $insurance->id }}"
                               --}}{{--Maybe change this to support_type--}}{{--
                               class="text-brand-color rounded-full form-checkbox focus:border-brand-color focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <span class="ml-2">{{ $insurance->title }}</span>
                    </label>
                @endforeach
            </div>--}}
            <div class="mb-4 text-sm">
                <x-label class="mb-2 font-bold">{{ __('Security measures') }}</x-label>
                @foreach($securityMeasures as $securityMeasure)
                    <label class="flex items-center mb-2 cursor-pointer">
                        <input type="hidden" name="securityMeasures[{{ $securityMeasure->id }}]" value="0">
                        <x-checkbox checked="{{ $address->securityMeasures->contains($securityMeasure->id) ? true : false }}" name="securityMeasures[{{ $securityMeasure->id }}]" value="1"/>
                        <span class="ml-2">{{ $securityMeasure->title }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </form>

    <div class="control_buttons flex justify-between">
        <div class="mb-4 text-sm text-right">
            <form method="post" action="{{ route('specialist.address.destroy', ['specialist' => auth()->user()->username, 'address' => $address->id]) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-600">{{ __('Delete address') }}</button>
            </form>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button type="submit" form="edit_address">{{ __('Save changes') }}</x-button>
        </div>
    </div>
</x-app-layout>
