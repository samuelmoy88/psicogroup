<x-app-layout>
    <form action="{{ route('clinic.addresses.update', ['uuid' => auth()->user()->uuid, 'address' => $address->id]) }}" method="post" id="edit_address">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl">
                    Editar dirección
                </h2>
                <a class="text-blue-500" href="{{ route('clinic.addresses.index', auth()->user()->uuid) }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('clinics.address_go_back') }}</a>
            </div>
        </div>
        <div class="form-card" x-data="">
            <h2 class="font-bold text-xl">{{ __('clinics.where') }}</h2>
            <div class="flex flex-wrap">
                <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4 relative">
                    <input type="hidden" name="latitude" id="latitude" value="{{ $address->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $address->longitude }}">
                    <x-label for="route">{{ __("common.street") }} *</x-label>
                    <x-input type="text" value="{{ $address->street }}" id="route" name="street"/>
                    <div id="street-results" class="absolute w-half hidden geo-coder-results"></div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4">
                    <x-label for="locality">{{ __("common.city") }} *</x-label>
                    <x-input type="text" value="{{ $address->city }}" id="locality" name="city"/>
                    <div id="city-results" class="absolute w-full hidden geo-coder-results"></div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                    <x-label for="postal_code">{{ __("common.zip") }} *</x-label>
                    <x-input type="text" value="{{ $address->zip_code }}" id="postal_code" name="zip_code"/>
                    <small>Si no conoces tu CP, haz click <a class="underline text-blue-500" rel="noreferrer noopener" href="http://www.codigopostal.gob.pe" target="_blank">aquí</a></small>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pr-4">
                    <x-label for="web_site">{{ __("common.website") }}</x-label>
                    <x-input type="text" value="{{ $address->web_site }}" id="web_site" name="web_site"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pr-4">
                    <x-label for="email">{{ __("clinics.contact_email") }}</x-label>
                    <x-input type="text" value="{{ $address->email }}" id="email" name="email"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4">
                    <x-label for="main_phone">{{ __("common.main_phone") }}</x-label>
                    <x-input type="tel" value="{{ $address->main_phone }}" id="main_phone" name="main_phone"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                    <x-label for="secondary_phone">{{ __("common.secondary_phone") }}</x-label>
                    <x-input type="tel" value="{{ $address->secondary_phone }}" id="secondary_phone" name="secondary_phone"/>
                </div>

                <div class="mb-4 text-sm">
                    <x-label class="mb-2">{{ __("address.patient_accessibility") }}</x-label>
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
            <h2 class="font-bold text-xl">{{ __('payment-methods.payment_methods') }}</h2>
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
            <h2 class="font-bold text-xl">{{ __('address.more_info') }}</h2>
            <div class="mb-4 text-sm">
                <x-label class="mb-2 font-bold">{{ __('security-measures.security_measures') }}</x-label>
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
            <form method="post" action="{{ route('clinic.address.destroy', ['uuid' => auth()->user()->uuid, 'address' => $address->id]) }}">
                @csrf
                @method('DELETE')
                <button class="text-red-600">{{ __('common.delete') }}</button>
            </form>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button type="submit" form="edit_address">{{ __('common.save_changes') }}</x-button>
        </div>
    </div>
</x-app-layout>
