<x-app-layout>
    <div class="mb-2">
        <nav>
            <ul class="flex space-x-2 text-xs profile-breadcrumbs">
                <li>
                    <a href="/" class="underline">{{ __('common.home') }}</a>
                </li>
                @if($specialist->profile->specialities)
                    <li class="">
                @foreach($specialist->profile->specialities as $specialities)
                    <a href="/search?speciality[]={{ $specialities->id }}" class="underline breadcrumbs-specialities">{{ $specialities->title }}</a>
                    @if($loop->index === 2) @break @endif
                @endforeach
                    </li>
                @endif
                @if($specialist->addresses)
                    <li>
                    @foreach($specialist->addresses as $address)
                        @if($address->city)
                            @if($loop->index > 0) @break @endif
                            <a href="/search?location={{ $address->city }}" class="underline">{{ $address->city }}</a>
                        @endif
                    @endforeach
                    </li>
                @endif
                <li>
                    {{ $specialist->profile->prefixLabel }} {{ $specialist->first_name }} {{ $specialist->last_name }}
                </li>
            </ul>
        </nav>
    </div>
    <div class="form-card sm:w-2/3 mb-4">
        <div class="flex">
            <div class="specialist-avatar mb-4 mr-4">
                <img src="{{ $specialist->profile->avatarPath }}" id="specialist-avatar" alt="specialist avatar"
                     class="rounded" height="140" width="140">
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold">{{ $specialist->profile->prefixLabel }} {{ $specialist->first_name }} {{ $specialist->last_name }}
                    @if($specialist->profile->is_verified) <i class="fas fa-check-circle text-brand-color"></i>@endif</h3>
                @if($specialist->profile->license_number)
                    <p class="text-xs mt-3 mb-2">{{ __('common.license_number') }}</p>
                    <p class="text-sm">{{ $specialist->profile->license_number }}</p>
                @endif
            </div>
        </div>
        <hr>
        <div class="xs:overflow-x-auto mb-4 relative" x-spread="container" x-data="tabs()">
            <ul class="flex" x-ref="tabs">
                @if(!$specialist->addresses->isEmpty())
                <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                    {{ __('common.consultations') }}</li>
                @endif
                @if(!$specialist->profile->specialities->isEmpty())
                <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                    {{ __('common.services') }}</li>
                @endif
                @if(!$specialist->profile->specialities->isEmpty() || $specialist->profile->diseases->isEmpty())
                <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                    {{ __('common.experience') }}</li>
                @endif
                @if(!$specialist->profile->ratings->isEmpty())
                <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                    {{ __('common.ratings') }} ({{ $specialist->profile->ratings->count() }})
                </li>
                @endif
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
                                    <span>{{ $address->clinic_name ? $address->clinic_name . ' - ' : '' }} {{ $address->title }}</span>
                                    <i class="fas fa-chevron-circle-down"></i>
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
                                            __('address.address_indications') : __('address.online_address_indications') }}</p>
                                                {{ $address->address_indications }}
                                            </div>
                                        @endif
                                    </div>
                                    @endif
                                    @if($address->web_site)
                                        <div class="address_element">
                                            <i class="fas fa-link mr-4"></i>
                                            <a href="{{ $address->getWebSite() }}" class="underline text-blue-500" target="_blank" rel="noopener">{{ $address->web_site }}</a>
                                        </div>
                                    @endif
                                    @if(count($address->accessibility) > 0)
                                        <div class="address_element flex-wrap">
                                            <span class="w-full font-light"><i class="fas fa-wheelchair mr-4"></i>{{ __('common.accessibility') }}</span>
                                            <ul class="pl-4">
                                            @foreach($address->accessibility as $accessibility)
                                                <li class="ml-4">{{ $accessibility->title }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(count($address->services) > 0)
                                        <div class="address_element flex-wrap">
                                            <span class="w-full"><i class="fas fa-stethoscope mr-4"></i>{{ __('services.services') }}</span>
                                            <ul class="pl-4">
                                            @foreach($address->services as $service)
                                                <li class="ml-4">{{ $dbServices->firstWhere('id', $service->service_id)->title }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if(count($address->paymentMethods) > 0)
                                        <div class="address_element flex-wrap">
                                            <span class="w-full"><i class="fas fa-money-bill-alt mr-3"></i>{{ __('payment-methods.payment_methods') }}</span>
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
                                    <i class="fas fa-chevron-circle-down"></i>
                                </div>
                            </button>
                            <div class="relative overflow-hidden transition-all max-h-0 duration-700" style=""
                                 x-ref="container{{ $loop->index }}"
                                 x-bind:style="selected == {{ $loop->index }} ? 'max-height: ' + $refs.container{{ $loop->index }}.scrollHeight + 'px' : ''">
                                <div class="p-6">
                                    @if ($service->pivot->description)
                                    <div class="mb-2">
                                        <p class="mb-2 font-light">{{ __('common.description') }}</p>
                                        <i class="font-bold">{{ $service->pivot->description }}</i>
                                    </div>
                                    @endif
                                    @if($service->pivot->price)
                                    <div class="mb-2">
                                        @if($service->pivot->price)
                                            <p class="mb-2 font-light">{{ __('common.price') }} {{ $service->pivot->price_from ? ' (desde)' : '' }}</p>
                                            <i class="font-bold">S/@money($service->pivot->price)</i>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
        @if($specialist->profile->specialities || $specialist->profile->diseases)
        <div class="hidden">
            @if ($specialist->profile->about)
                <div class="form-card sm:w-2/3 mb-4">
                    <div class="mb-4 flex flex-wrap">
                        <span class="w-full font-light">{{ __('specialists.field_about') }}</span>
                        <span class="px-2">{{ $specialist->profile->about }}</span>
                    </div>
                </div>
            @endif
            @if($specialist->profile->specialities)
            <div class="form-card sm:w-2/3 mb-4">
                <div class="mb-4">
                    Especialidades {{ '('.count($specialist->profile->specialities).')' }}
                    <div class="mt-4 bg-white border border-gray-200">
                        <ul class="shadow-box">
                            @foreach($specialist->profile->specialities as $specialities)
                                <li class="relative border-b border-gray-200" x-data="{selected:null}">
                                    <div class="w-full px-8 py-6 text-left">
                                        <div class="flex items-center justify-between">
                                            <span>{{ $specialities->title }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            @if($specialist->profile->diseases)
            <div class="form-card sm:w-2/3 mb-4">
                <div class="mb-4">
                    Patologías {{ '('.count($specialist->profile->diseases).')' }}
                    <div class="mt-4 bg-white border border-gray-200">
                        <ul class="shadow-box">
                            @foreach($specialist->profile->diseases as $diseases)
                                <li class="relative border-b border-gray-200" x-data="{selected:null}">
                                    <div class="w-full px-8 py-6 text-left">
                                        <div class="flex items-center justify-between">
                                            <span>{{ $diseases->title }}</span>
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
        @endif
        @if($specialist->profile->ratings)
        <div class="hidden">
            <div class="form-card sm:w-2/3 mb-4">
                @foreach($specialist->profile->ratings as $rating)
                    @if(!$rating->remarks) @continue @endif
                    <div class="mb-4">
                        <div class="mb-3">
                            <p>{{ $rating->patient->user->first_name }} {{ $rating->patient->user->last_name }}</p>
                            @if($rating->patient->is_verified)
                                <p>{{ __('ratings.verified_patient') }} <i class="fas fa-check-circle text-brand-color ml-2 "></i></p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <small>
                                {{ $rating->consultation->created_at->locale('es_ES')->format('j \d\e F \d\e Y') }}
                                |
                                {{ $rating->consultation->address->title }}
                                |
                                {{ $rating->consultation->service->title }}
                            </small>
                        </div>
                        <div class="mb-3">
                            {{ $rating->remarks }}
                        </div>
                        @if($rating->specialist_reply)
                            <div class="flex items-start space-x-3">
                                <div class="p-4 bg-gray-200 rounded flex-1 min-w-0">
                                    <small class="mb-2">
                                        {{ __('ratings.specialist_reply') }}
                                        {{ $rating->specialist->prefix_id ? $rating->specialist->prefixLabel : ''}}
                                        {{ $rating->specialist->user->first_name }} {{ $rating->specialist->user->last_name }}
                                    </small>
                                    <p class="">
                                        {{ $rating->specialist_reply }}
                                    </p>
                                </div>
                                <div class="flex-shink-0">
                                    <img class="object-cover h-10 w-10 rounded-full" src="{{ $specialist->profile->avatarPath }}" alt="" loading="lazy">
                                </div>
                            </div>
                        @endif
                        <hr class="border-t-2 border-gray-2 my-4">
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
