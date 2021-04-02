<x-app-layout>
    <form action="{{ route('specialist.addresses.update', ['uuid' => auth()->user()->uuid, 'address' => $address->id]) }}" method="post" id="edit_address">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl">
                    {{ $address->consultation_type == 'physical' ? __('address.edit_physical') : __('address.edit_online') }}
                </h2>
                <a class="text-blue-500" href="{{ route('specialist.addresses.index', auth()->user()->uuid) }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('address.go_back') }}</a>
            </div>
        </div>

        <div class="form-card" x-data="">
            <h2 class="font-bold text-xl">{{ __('address.where') }}</h2>
            <div class="mt-4 mb-4 text-sm">
                <label class="mb-1 cursor-pointer mr-2">
                    <x-radio checked="{{ $address->is_private == '1' ? true : false }}"  @click="toggleElement($refs.clinicName, 'off')"
                             value="1" name="is_private"/> {{__('address.private')}}
                </label>
                <label class="mb-1 cursor-pointer mr-2">
                    <x-radio checked="{{ $address->is_private == '0' ? true : false }}"  @click="toggleElement($refs.clinicName, 'on')"
                             value="0" name="is_private"/> {{__('address.medical')}}
                </label>
            </div>
            <div class="flex flex-wrap">
                <div class="mb-4 text-sm w-full {{ $address->is_private == '1' ? 'hidden' : '' }}" x-ref="clinicName">
                    <x-label for="clinic_name">{{ __("address.clinic_name") }} *</x-label>
                    <x-input type="text" value="{{ $address->clinic_name }}" id="clinic_name" name="clinic_name"/>
                </div>

                <div class="mb-4 text-sm w-full">
                    <x-label for="title">{{ __("address.consultation_name") }} *</x-label>
                    <x-input type="text" value="{{ $address->title }}" id="title" name="title"/>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4 relative">
                    <input type="hidden" name="latitude" id="latitude" value="{{ $address->latitude }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ $address->longitude }}">
                    <x-label for="street">{{ __("common.street") }} *</x-label>
                    <x-input type="text" value="{{ $address->street }}" id="street" name="street"/>
                    <div id="street-results" class="absolute w-half hidden geo-coder-results"></div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4">
                    <x-label for="city">{{ __("common.city") }} *</x-label>
                    <x-input type="text" value="{{ $address->city }}" id="city" name="city"/>
                    <div id="city-results" class="absolute w-full hidden geo-coder-results"></div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                    <x-label for="zip_code">{{ __("common.zip") }} *</x-label>
                    <x-input type="text" value="{{ $address->zip_code }}" id="zip_code" name="zip_code"/>
                    <small>Si no conoces tu CP, haz click <a class="underline text-blue-500" href="http://www.codigopostal.gob.pe" target="_blank">aquí</a></small>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4">
                    <x-label for="web_site">{{ __("common.website") }}</x-label>
                    <x-input type="text" value="{{ $address->web_site }}" id="web_site" name="web_site"/>
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
            @if($address->consultation_type === \App\Models\Address::TYPE_PHYSICAL)
            <h2 class="font-bold text-xl">{{ __('address.address_indications') }}</h2>
            <p class="text-bold text-black">Información que los pacientes recibirán tras agendar cita y que les ayudará
                a encontrar su consulta más fácilmente. P. ej. cómo acceder al edificio de entrada, cómo llegar con
                transporte público, etc.</p>
            @endif
            @if($address->consultation_type === \App\Models\Address::TYPE_ONLINE)
            <h2 class="font-bold text-xl">{{ __('address.online_address_indications') }}</h2>
            @endif
            <div class="my-4 text-sm">
                <x-textarea name="address_indications" id="address_indications">{{ $address->address_indications }}</x-textarea>
            </div>
            @if($address->consultation_type === \App\Models\Address::TYPE_ONLINE)
                <div class="my-4 text-sm">
                    <ul class="pl-4 text-small list-disc">
                        <li class="pt-3 text-gray-500">Cómo se realizará la consulta: teléfono, videollamada, etc. Ej: Skype, Whatsapp, Google Hangouts, Zoom...</li>
                        <li class="pt-3 text-gray-500">Si la consulta es a través de alguna aplicación (como Skype, WhatsApp o Zoom) dígale al paciente qué necesita descargarse y/o cómo registrarse.</li>
                        <li class="pt-3 text-gray-500">Si la consulta es a través de Skype, escriba su usuario y pídale al paciente que le agregue a su lista de contactos. Si la consulta es telefónica, escriba su número de teléfono.</li>
                        <li class="pt-3 text-gray-500">Hágale saber al paciente si le contactará antes de la consulta para ofrecerle información adicional o un enlace para iniciar la videollamada, y cuándo lo va a hacer.</li>
                        <li class="pt-3 text-gray-500">Si quiere que el paciente le contacte, o si desea añadir alguna otra información relevante, puede hacerlo aquí.</li>
                    </ul>
                </div>
            @endif
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
            @if($address->consultation_type === \App\Models\Address::TYPE_ONLINE)
            <div class="">
                <div class="mb-4 text-sm">
                    <h3 class="mb-4 text-lg font-bold text-black">{{ __('address.payment_after') }}</h3>
                    <input type="hidden" name="payment_after" value="0">
                    <x-toggle-checkbox :value="1" checked="{{ $address->payment_after ? 'true' : '' }}"
                                       :id="'payment_after'">{{ __('address.request_payment_after') }}</x-toggle-checkbox>
                    <p class="mt-4 text-gray">
                        Active esta opción para que los pacientes, en lugar de hacerlo antes, realicen el pago por su
                        consulta justo después de terminarla. Esta información también aparecerá en su perfil para que
                        los pacientes prefieran reservar una consulta con usted.
                    </p>
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="payment_details" class="mb-2 font-bold">{{ __("address.payment_details") }}</x-label>
                    <x-textarea placeholder="{{ __('common.type_here') }}" name="payment_details" id="payment_details"
                        >{{ $address->payment_details }}</x-textarea>
                    <ul class="pl-4 text-small list-disc">
                        <li class="pt-3 text-sm text-gray-500">¿Qué plazo tiene el paciente para realizar el pago?</li>
                        <li class="pt-3 text-sm text-gray-500">Información necesaria para relizar el pago (datos bancarios, teléfono para pagos a través de apps...).</li>
                        <li class="pt-3 text-sm text-gray-500">¿Necesita la confirmación del pago por email? No se olvide de facilitar el email al paciente.</li>
                    </ul>
                </div>
            </div>
            @endif
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('address.more_info') }}</h2>
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
            <form method="post" action="{{ route('specialist.address.destroy', ['uuid' => auth()->user()->uuid, 'address' => $address->id]) }}">
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
