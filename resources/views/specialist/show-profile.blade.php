<x-app-layout>
    <div class="form-card sm:w-2/3 mb-4">
        <div class="flex">
            <div class="specialist-avatar mb-4 mr-4">
                <img src="{{ $specialist->profile->avatarPath }}" id="specialist-avatar" alt="specialist avatar"
                     class="rounded" height="140" width="140">
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold">{{ $specialist->first_name }} {{ $specialist->last_name }}
                    @if($specialist->profile->is_verified) <i class="fas fa-check-circle text-brand-color"></i>@endif</h3>
                @if($specialist->profile->license_number)
                    <p class="text-xs mt-3 mb-2">Número de colegiado</p>
                    <p class="text-sm">{{ $specialist->profile->license_number }}</p>
                @endif
            </div>
        </div>
        <hr>
        <div class="xs:overflow-x-auto mb-4 relative" x-spread="container" x-data="tabs()">
            <ul class="flex" x-ref="tabs">
                <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                    Consultorios
                </li>
                <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                    Servicios
                </li>
                {{--<li class="mr-2 p-2 border-b-2 border-brand-color-bottom text-brand-color">
                    Opiniones
                </li>--}}
                <div x-spread="indicator" class="border-t-2 border-brand-color-top absolute left-0 bottom-0 transition-all duration-500"></div>
            </ul>
        </div>
    </div>
    <div x-ref="cards">
        @if($specialist->addresses)
        <div class="form-card sm:w-2/3 mb-4">
            <div class="mb-4">
                Consultorios {{ '('.count($specialist->addresses).')' }}
                @if($specialist->addresses)
                <div class="mt-4 bg-white border border-gray-200">
                    <ul class="shadow-box">
                        @foreach($specialist->addresses as $address)
                        <li class="relative border-b border-gray-200" x-data="{selected:null}">
                            <button type="button" class="w-full px-8 py-6 text-left"
                                    @click="selected !== {{ $loop->index }} ? selected = {{ $loop->index }} : selected = null"
                                    x-bind:class="{'border-l-2 border-brand-color-left text-brand-color bg-gray-100' : selected == {{ $loop->index }}}">
                                <div class="flex items-center justify-between">
                                    <span>{{ $address->title }}</span>
                                    <span class="ico-plus"></span>
                                </div>
                            </button>
                            <div class="relative overflow-hidden transition-all max-h-0 duration-700" style=""
                                 x-ref="container{{ $loop->index }}"
                                 x-bind:style="selected == {{ $loop->index }} ? 'max-height: ' + $refs.container{{ $loop->index }}.scrollHeight + 'px' : ''">
                                <div class="p-6 address_elements">
                                    @if($address->street || $address->city)
                                    <div class="address_element flex-wrap">
                                        <i class="fas fa-map-marked-alt mr-4"></i>
                                        <address class="flex-1">
                                            @if($address->street) {{ $address->street }}<br/> @endif
                                            @if($address->city) {{ $address->city }} @endif @if($address->zip_code) {{ $address->zip_code }} @endif
                                        </address>
                                        @if($address->address_indications)
                                            <div class="w-full mt-4 ml-8">
                                                <p>{{ $address->consultation_type == 'physical' ?
                                            __('Indications to arrive') : __('How to connect to the consultation') }}</p>
                                                {{ $address->address_indications }}
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                    @if($address->web_site)
                                        <div class="address_element">
                                            <i class="fas fa-link mr-4"></i>
                                            <a href="{{ $address->web_site }}" class="underline text-blue-500" target="_blank" rel="noopener">{{ $address->web_site }}</a>
                                        </div>
                                    @endif
                                    @if($address->accessibility)
                                        <div class="address_element flex-wrap">
                                            <span class="w-full"><i class="fas fa-wheelchair mr-4"></i>{{ __('Accessibility') }}</span>
                                            <ul class="pl-4">
                                            @foreach($address->accessibility as $accessibility)
                                                <li class="ml-4">{{ $accessibility->title }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if($address->services)
                                        <div class="address_element flex-wrap">
                                            <span class="w-full"><i class="fas fa-stethoscope mr-4"></i>{{ __('services.services') }}</span>
                                            <ul class="pl-4">
                                            @foreach($address->services as $service)
                                                <li class="ml-4">{{ $dbServices->firstWhere('id', $service->service_id)->title }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if($address->paymentMethods)
                                        <div class="address_element flex-wrap">
                                            <span class="w-full"><i class="fas fa-money-bill-alt mr-3"></i>{{ __('Payment methods') }}</span>
                                            <ul class="pl-4">
                                                @foreach($address->paymentMethods as $paymentMethod)
                                                    <li class="ml-4">{{ $paymentMethod->title }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        @endif
        @if($specialist->profile->services)
        <div class="form-card sm:w-2/3 mb-4 hidden">
            <div class="mb-4">
                Servicios {{ '('.count($specialist->profile->services).')' }}
                <div class="mt-4 bg-white border border-gray-200">
                    <ul class="shadow-box">
                    @foreach($specialist->profile->services as $service)
                        <li class="relative border-b border-gray-200" x-data="{selected:null}">
                            <button type="button" class="w-full px-8 py-6 text-left"
                                    @click="selected !== {{ $loop->index }} ? selected = {{ $loop->index }} : selected = null"
                                    x-bind:class="{'border-l-2 border-brand-color-left text-brand-color bg-gray-100' : selected == {{ $loop->index }}}">
                                <div class="flex items-center justify-between">
                                    <span>{{ $service->title }}</span>
                                    <span class="ico-plus"></span>
                                </div>
                            </button>
                            <div class="relative overflow-hidden transition-all max-h-0 duration-700" style=""
                                 x-ref="container{{ $loop->index }}"
                                 x-bind:style="selected == {{ $loop->index }} ? 'max-height: ' + $refs.container{{ $loop->index }}.scrollHeight + 'px' : ''">
                                <div class="p-6">
                                    <div class="mb-2">
                                        <p class="mb-2">{{ __('Details') }}</p>
                                        <i>{{ $service->pivot->description }}</i>
                                    </div>
                                    <div class="mb-2">
                                        @if($service->pivot->price)
                                            <p class="mb-2">{{ __('Price') }} {{ $service->pivot->price_from ? ' (desde)' : '' }}</p>
                                            S/@money($service->pivot->price)
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
