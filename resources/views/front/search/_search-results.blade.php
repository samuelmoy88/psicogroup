@if($specialists->count() > 0)
    @foreach($specialists as $specialist)
        <div class="form-card h-72">
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
                        @if($specialist['specialities'])
                            <p class="font-light">{{ implode(', ', $specialist['specialities']) }}</p>
                        @endif
                    </div>
                    @if($specialist['has_online_consultation'])
                        <div class="w-full">
                            <span><i class="fas fa-video mr-2"></i> {{ __('common.has_online_consultation') }}</span>
                        </div>
                    @endif
                </div>
            </div>
            <div class="flex relative" x-spread="container" x-data="tabs()">
                @if(count($specialist['addresses']))
                    <ul class="flex" x-ref="tabs">
                        @foreach($specialist['addresses'] as $key => $address)
                            <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                                {{ $address['consultation_type'] !== 'online' ? __('common.address') .' '. (1 + $key) : __('address.online') }}
                            </li>
                        @endforeach
                    </ul>
                    <div x-spread="indicator"
                         class="border-t-2 border-brand-color-top absolute left-0 bottom-0 transition-all duration-500"></div>
                @endif
            </div>
            <hr class="bg-gray-100"/>
            <div x-ref="cards">
                @if(count($specialist['addresses']) > 0)
                    @foreach($specialist['addresses'] as $key => $address)
                        <div class="mt-3 transition-all duration-700 {{ $key !== 0 ? 'hidden' : '' }}"
                             style="">
                            @if($address['consultation_type'] !== 'online')
                                <div class="flex mb-2">
                                    <i class="fas fa-map-marked-alt mr-2 text-gray-500"></i>
                                    <div>
                                        <p>{{ $address['street'] }}, {{ $address['city'] }}
                                            , {{ $address['zip_code'] }}</p>
                                        <p>{{ $address['title'] }}</p>
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
        </div>@php //var_dump($specialist); @endphp
    @endforeach
@endif
