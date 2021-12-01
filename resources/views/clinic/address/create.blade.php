<x-app-layout>
    <form action="{{ route('clinic.addresses.store', auth()->user()->username) }}" method="post" x-data="toggle()">
        @csrf
        <div class="text-right mb-4">
            <a class="text-blue-500" href="{{ route('clinic.addresses.index', auth()->user()->username) }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('clinics.address_go_back') }}</a>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('address.type') }}</h2>
            <p class="text-bold text-black">{{ __('address.physical_or_online') }}</p>
            <div class="mt-4 mb-4 text-sm">
                <label @click="toggleOnlineConsultation($refs.physicalIndications, $refs.onlineIndications, $refs.onlineDetails, $refs.onlinePaymentDetails, $refs.otherInformation, $refs.street, $refs.city, $refs.zip,'off')"
                       class="mb-1 cursor-pointer mr-2">
                    <x-radio value="physical" checked name="consultation_type"/> {{__('address.physical')}}
                </label>
                <label @click="toggleOnlineConsultation($refs.physicalIndications, $refs.onlineIndications, $refs.onlineDetails, $refs.onlinePaymentDetails, $refs.otherInformation, $refs.street, $refs.city, $refs.zip,'on')"
                       class="mb-1 cursor-pointer mr-2">
                    <x-radio value="online" name="consultation_type"/> {{__('address.online')}}
                </label>
            </div>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-xl mb-2">{{ __('clinics.where') }}</h2>
            <div class="flex flex-wrap">
                <div class="flex flex-wrap w-full">
                    <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4" x-ref="street">
                        <input type="hidden" name="latitude" id="latitude" value="">
                        <input type="hidden" name="longitude" id="longitude" value="">
                        <x-label for="route">{{ __("common.street") }} *</x-label>
                        <x-input type="text" value="" id="route" name="street"/>
                        <div id="street-results" class="absolute w-half hidden geo-coder-results"></div>
                    </div>

                    <div class="mb-4 text-sm w-full md:w-1/4" x-ref="city">
                        <x-label for="locality">{{ __("common.city") }} *</x-label>
                        <x-input type="text" value="" id="locality" name="city"/>
                        <div id="city-results" class="absolute w-full hidden geo-coder-results"></div>
                    </div>

                    <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4"x-ref="zip">
                        <x-label for="postal_code">{{ __("common.zip") }} *</x-label>
                        <x-input type="text" value="" id="postal_code" name="zip_code"/>
                        <small>Si no conoces tu CP, haz click <a class="underline text-blue-500" href="http://www.codigopostal.gob.pe" rel="noreferrer noopener" target="_blank">aquí</a></small>
                    </div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pr-4">
                    <x-label for="web_site">{{ __("common.website") }}</x-label>
                    <x-input type="text" value="" id="web_site" name="web_site"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pr-4">
                    <x-label for="email">{{ __("clinics.contact_email") }}</x-label>
                    <x-input type="text" value="" id="email" name="email"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4">
                    <x-label for="main_phone">{{ __("common.main_phone") }}</x-label>
                    <x-input type="text" value="" id="main_phone" name="main_phone"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                    <x-label for="secondary_phone">{{ __("common.secondary_phone") }}</x-label>
                    <x-input type="text" value="" id="secondary_phone" name="secondary_phone"/>
                </div>

                <div class="mb-4 text-sm">
                    <x-label class="mb-2">{{ __("address.patient_accessibility") }}</x-label>
                    @foreach($addressAccessibility as $accessibility)
                        <label class="flex items-center mb-2 cursor-pointer">
                            <x-checkbox name="accessibility[{{ $accessibility->id }}]" value="1"/>
                            <span class="ml-2">{{ $accessibility->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="hidden">
            <div x-ref="physicalIndications"></div>
            <div x-ref="onlineIndications"></div>
            <div x-ref="onlineDetails"></div>
            <div x-ref="onlinePaymentDetails"></div>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('payment-methods.payment_methods') }}</h2>
            <div class="mb-4 text-sm flex">
                @foreach($paymentMethods as $key => $paymentMethod)
                    @if($key == 0 || round(count($paymentMethods) / 2) == $key )
                        <div class="w-full md:w-1/2">
                    @endif
                    <label class="flex items-center mb-2 cursor-pointer">
                        <x-checkbox name="paymentMethods[]" value="{{ $paymentMethod->id }}"/>
                        <span class="ml-2">{{ $paymentMethod->title }}</span>
                    </label>
                    @if($key == (count($paymentMethods) - 1) || round(count($paymentMethods) / 2) == ($key + 1))
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="form-card" x-ref="otherInformation">
            <h2 class="font-bold text-xl">{{ __('address.more_info') }}</h2>
            <div class="mb-4 text-sm">
                <x-label class="mb-2 font-bold">{{ __('security-measures.security_measures') }}</x-label>
                @foreach($securityMeasures as $securityMeasure)
                    <label class="flex items-center mb-2 cursor-pointer">
                        <x-checkbox name="securityMeasures[]" value="{{ $securityMeasure->id }}"/>
                        <span class="ml-2">{{ $securityMeasure->title }}</span>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-app-layout>
