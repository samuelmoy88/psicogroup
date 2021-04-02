<x-app-layout>
    <form action="{{ route('specialist.addresses.store', auth()->user()->username) }}" method="post" x-data="toggle()">
        @csrf
        <div class="text-right mb-4">
            <a class="text-blue-500" href="{{ route('specialist.addresses.index', auth()->user()->username) }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('address.go_back') }}</a>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('address.type') }}</h2>
            <p class="text-bold text-black">{{ __('address.physical_or_online') }}</p>
            <div class="mt-4 mb-4 text-sm">
                <label @click="toggleOnlineConsultation($refs.physicalIndications, $refs.onlineIndications, $refs.physicalAddress, $refs.onlineDetails, $refs.onlinePaymentDetails, $refs.otherInformation, 'off')"
                       class="mb-1 cursor-pointer mr-2">
                    <x-radio value="physical" checked name="consultation_type"/> {{__('address.physical')}}
                </label>
                <label @click="toggleOnlineConsultation($refs.physicalIndications, $refs.onlineIndications, $refs.physicalAddress, $refs.onlineDetails, $refs.onlinePaymentDetails, $refs.otherInformation, 'on')"
                       class="mb-1 cursor-pointer mr-2">
                    <x-radio value="online" name="consultation_type"/> {{__('address.online')}}
                </label>
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('address.where') }}</h2>
            <div class="mt-4 mb-4 text-sm">
                <label class="mb-1 cursor-pointer mr-2">
                    <x-radio value="1" name="is_private" @click="toggleElement($refs.clinicName, 'off')"/> {{__('address.private')}}
                </label>
                <label class="mb-1 cursor-pointer mr-2">
                    <x-radio value="0" name="is_private" @click="toggleElement($refs.clinicName, 'on')"/> {{__('address.medical')}}
                </label>
            </div>
            <div class="flex flex-wrap">
                <div class="mb-4 text-sm w-full hidden" x-ref="clinicName">
                    <x-label for="clinic_name">{{ __("address.clinic_name") }}</x-label>
                    <x-input type="text" value="" id="clinic_name" name="clinic_name"/>
                </div>

                <div class="mb-4 text-sm w-full">
                    <x-label for="title">{{ __("address.consultation_name") }} *</x-label>
                    <x-input type="text" value="" id="title" name="title"/>
                </div>

                <div class="flex flex-wrap w-full" x-ref="physicalAddress">
                    <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4">
                        <input type="hidden" name="latitude" id="latitude" value="">
                        <input type="hidden" name="longitude" id="longitude" value="">
                        <x-label for="street">{{ __("common.street") }} *</x-label>
                        <x-input type="text" value="" id="street" name="street"/>
                        <div id="street-results" class="absolute w-half hidden geo-coder-results"></div>
                    </div>

                    <div class="mb-4 text-sm w-full md:w-1/4">
                        <x-label for="city">{{ __("common.city") }} *</x-label>
                        <x-input type="text" value="" id="city" name="city"/>
                        <div id="city-results" class="absolute w-full hidden geo-coder-results"></div>
                    </div>

                    <div class="mb-4 text-sm w-full md:w-1/4 md:pl-4">
                        <x-label for="zip_code">{{ __("common.zip") }} *</x-label>
                        <x-input type="text" value="" id="zip_code" name="zip_code"/>
                        <small>Si no conoces tu CP, haz click <a class="underline text-blue-500" href="http://www.codigopostal.gob.pe" target="_blank">aquí</a></small>
                    </div>
                </div>

                <div class="mb-4 text-sm w-full md:w-1/2 md:pr-4">
                    <x-label for="web_site">{{ __("common.website") }}</x-label>
                    <x-input type="text" value="" id="web_site" name="web_site"/>
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

        <div class="form-card">
            <div x-ref="physicalIndications">
                <h2 class="font-bold text-xl">{{ __('address.address_indications') }}</h2>
            </div>
            <div class="hidden" x-ref="onlineIndications">
                <h2 class="font-bold text-xl">{{ __('address.online_address_indications') }}</h2>
            </div>
            <p class="text-bold text-black">Información que los pacientes recibirán tras agendar cita y que les ayudará
                a encontrar su consulta más fácilmente. P. ej. cómo acceder al edificio de entrada, cómo llegar con
                transporte público, etc.</p>
            <div class="my-4 text-sm">
                <x-textarea name="address_indications" id="address_indications"></x-textarea>
            </div>
            <div class="my-4 text-sm hidden" x-ref="onlineDetails">
                <ul class="pl-4 text-small list-disc">
                    <li class="pt-3 text-gray-500">Cómo se realizará la consulta: teléfono, videollamada, etc. Ej: Skype, Whatsapp, Google Hangouts, Zoom...</li>
                    <li class="pt-3 text-gray-500">Si la consulta es a través de alguna aplicación (como Skype, WhatsApp o Zoom) dígale al paciente qué necesita descargarse y/o cómo registrarse.</li>
                    <li class="pt-3 text-gray-500">Si la consulta es a través de Skype, escriba su usuario y pídale al paciente que le agregue a su lista de contactos. Si la consulta es telefónica, escriba su número de teléfono.</li>
                    <li class="pt-3 text-gray-500">Hágale saber al paciente si le contactará antes de la consulta para ofrecerle información adicional o un enlace para iniciar la videollamada, y cuándo lo va a hacer.</li>
                    <li class="pt-3 text-gray-500">Si quiere que el paciente le contacte, o si desea añadir alguna otra información relevante, puede hacerlo aquí.</li>
                </ul>
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
                        <x-checkbox name="paymentMethods[]" value="{{ $paymentMethod->id }}"/>
                        <span class="ml-2">{{ $paymentMethod->title }}</span>
                    </label>
                    @if($key == (count($paymentMethods) - 1) || round(count($paymentMethods) / 2) == ($key + 1))
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="hidden" x-ref="onlinePaymentDetails">
                <div class="mb-4 text-sm">
                    <h3 class="mb-4 text-lg font-bold text-black">{{ __('address.payment_after') }}</h3>
                    <x-toggle-checkbox :value="1"
                                       :id="'payment_after'">{{ __('address.request_payment_after') }}</x-toggle-checkbox>
                    <p class="mt-4 text-gray">
                        Active esta opción para que los pacientes, en lugar de hacerlo antes, realicen el pago por su
                        consulta justo después de terminarla. Esta información también aparecerá en su perfil para que
                        los pacientes prefieran reservar una consulta con usted.
                    </p>
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="payment_details" class="mb-2 font-bold">{{ __("address.payment_details") }}</x-label>
                    <x-textarea placeholder="{{ __('common.type_here') }}" name="payment_details" id="payment_details"></x-textarea>
                    <ul class="pl-4 text-small list-disc">
                        <li class="pt-3 text-sm text-gray-500">¿Qué plazo tiene el paciente para realizar el pago?</li>
                        <li class="pt-3 text-sm text-gray-500">Información necesaria para relizar el pago (datos bancarios, teléfono para pagos a través de apps...).</li>
                        <li class="pt-3 text-sm text-gray-500">¿Necesita la confirmación del pago por email? No se olvide de facilitar el email al paciente.</li>
                    </ul>
                </div>
            </div>
        </div>

        {{--<div class="form-card" x-ref="services">
            <h2 class="font-bold text-xl">{{ __('Your services') }}</h2>
            <p class="text-bold text-black mb-4">Hemos seleccionado para usted una lista de los servicios más populares
                de su especialidad. Por favor, marque los que usted realiza.</p>
            <div class="mt-4 mb-4 services_block">
                @foreach($services as $key => $service)
                    <div class="p-4 mb-4 text-sm w-full flex space-x-4 flex-col md:flex-row bg-gray-100">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle"></i>
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="flex items-center mb-2 cursor-pointer">
                                <x-checkbox name="services[{{ $service->id }}][service_id]" value="{{ $service->id }}"/>
                                <span class="ml-2">{{ $service->title }}</span>
                            </label>
                            <x-textarea rows="3" placeholder="{{ __('Add details about the service so patients want to choose you when looking for a specialist ') }}" name="services[{{ $service->id }}][description]"></x-textarea>
                        </div>
                        <div class="flex flex-wrap space-x-4 items-start">
                            <label class="flex items-center mb-2 cursor-pointer">
                                <x-checkbox name="services[{{ $service->id }}][price_from]" value="1"/>
                                <span class="ml-2">{{ __('From') }}</span>
                            </label>
                            <div class="relative text-gray-500">
                                <x-input value="" id="" name="services[{{ $service->id }}][price]"/>
                                <button class="absolute inset-y-0 right-0 rounded-r-md inline-flex items-center px-4 py-2 bg-brand-color border border-transparent font-medium text-white tracking-widest active:bg-purple-800 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple disabled:opacity-25 transition ease-in-out duration-150">S/</button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <livewire:address-service/>
            </div>
        </div>--}}

        <div class="form-card" x-ref="otherInformation">
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
