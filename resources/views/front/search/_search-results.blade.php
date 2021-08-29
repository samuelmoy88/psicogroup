@if(!$specialists->isEmpty())
    @foreach($specialists as $specialist)
        <div class="form-card h-80">
            <div class="flex flex-wrap">
                <div class="specialist-avatar">
                    <a href="{{ route('specialist.show', ['specialist' => $specialist['username'], 'uuid' => $specialist['uuid']]) }}">
                        <img loading="lazy" src="{{ $specialist['avatar'] }}" alt="{{ __('common.specialist_avatar') }}"
                             class="rounded" height="100" width="100"></a>
                </div>
                <div class="flex-1">
                    <div class="w-full">
                        <h3 class="text-xl font-semibold">
                            <a href="{{ route('specialist.show', ['specialist' => $specialist['username'], 'uuid' => $specialist['uuid']]) }}">
                                {{ $specialist['full_name'] }}</a>
                            @if($specialist['is_verified']) <i
                                class="fas fa-check-circle text-brand-color"></i> @endif</h3>
                        @if(isset($specialist['specialities']) && $specialist['specialities'])
                            <p class="font-light short-specialities">
                                @foreach($specialist['specialities'] as $speciality)
                                {{ $speciality }},
                                    @if($loop->index >= 1)
                                        <span class="text-xs toggle-specialities cursor-pointer underline">ver más...</span>
                                        @break
                                    @endif
                                    @endforeach</p>
                            <p class="hidden all-specialities">{{ implode(', ', $specialist['specialities']) }}.
                                <span class="text-xs toggle-specialities cursor-pointer underline">ver menos...</span></p>
                        @endif
                    </div>
                    @if($specialist['has_online_consultation'])
                        <div class="w-full">
                            <span><i class="fas fa-video mr-2"></i> {{ __('common.has_online_consultation') }}</span>
                        </div>
                    @endif
                </div>
                @if(isset($specialist['addresses']) && count($specialist['addresses']) > 0)
                <div data-specialist="{{ $specialist['uuid'] }}">
                    @foreach($specialist['addresses'] as $key => $address)
                    <a data-consultation="{{ $address['id'] }}"
                        class="{{ $loop->index > 0 ? 'hidden' : '' }} loading inline-flex items-center px-2 py-1 bg-brand-color border border-transparent rounded-md font-medium text-sm text-white tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route(
                       'consultation.create',
                       ['doctor' => $specialist['uuid'], 'address' => $address['id']]
                       ) }}"
                    >{{ __('common.request_appointment') }}</a>
                    @endforeach
                </div>
                @endif
            </div>
            @if(isset($specialist['addresses']) && count($specialist['addresses']) > 0)
            <div class="flex relative" x-spread="container" x-data="tabs()">
                    <ul class="flex" x-ref="tabs">
                        @foreach($specialist['addresses'] as $key => $address)
                            <li x-spread="tab" data-ref="{{ $address['id'] }}" data-parent="{{ $specialist['uuid'] }}" class="transition mr-2 p-2 cursor-pointer">
                                {{ $address['consultation_type'] !== 'online' ? __('common.address') .' '. (1 + $key) : __('address.online') }}
                            </li>
                        @endforeach
                    </ul>
                    <div x-spread="indicator"
                         class="border-t-2 border-brand-color-top absolute left-0 bottom-0 transition-all duration-500"></div>
            </div>
            @endif
            <hr class="bg-gray-100"/>
            <div class="max-h-28 overflow-y-auto">
                <div x-ref="cards">
                    @if(isset($specialist['addresses']) && count($specialist['addresses']) > 0)
                        @foreach($specialist['addresses'] as $key => $address)
                            <div data-show="{{ $address['id'] }}" data-hide="{{ $specialist['uuid'] }}" class="mt-3 transition-all duration-700 {{ $key !== 0 ? 'hidden' : '' }}"
                                 style="">
                                @if($address['street'] && $address['city'])
                                    <div class="flex mb-2">
                                        <i class="fas fa-map-marked-alt mr-2 text-gray-500"></i>
                                        <div>
                                            <p>{{ $address['street'] }}, {{ $address['city'] }}
                                                , {{ $address['zip_code'] }}</p>
                                            <p>{{ $address['title'] }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if(count($address['online_platforms']) > 0)
                                    <div class="flex">
                                        <i class="fas fa-video mr-2 text-gray-500"></i>
                                        <div>
                                            <p>Vía {{ implode(', ', $address['online_platforms']) }}</p>
                                        </div>
                                    </div>
                                @endif
                                @foreach($address['services'] as $service)
                                    <div class="flex">
                                        <i class="fas fa-money-bill-alt mr-2 text-gray-500"></i>
                                        <div>
                                            <p>{{ $service['title'] }}
                                                <i class="font-bold">S/@money($service['price'])</i></p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    @else
    @include('components.no-search-results')
@endif
