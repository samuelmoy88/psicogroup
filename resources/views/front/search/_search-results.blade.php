@if(!$searchResults->isEmpty())
    @foreach($searchResults as $searchResult)
        <div class="form-card h-80">
            <div class="flex flex-wrap">
                <div class="specialist-avatar">
                    <a href="{{ $searchResult['profile_type'] === \App\Models\SpecialistProfile::class ?
                    route('specialist.show', ['specialist' => $searchResult['username'], 'uuid' => $searchResult['uuid']]) :
                    route('clinic.show', ['medical_center' => $searchResult['username'], 'uuid' => $searchResult['uuid']]) }}">
                        <img loading="lazy" src="{{ asset($searchResult['avatar']) }}" alt="{{ __('common.specialist_avatar') }}"
                             class="rounded" height="100" width="100"></a>
                </div>
                <div class="flex-1">
                    <div class="w-full">
                        <h3 class="text-xl font-semibold">
                            <a href="{{ $searchResult['profile_type'] === \App\Models\SpecialistProfile::class ?
                    route('specialist.show', ['specialist' => $searchResult['username'], 'uuid' => $searchResult['uuid']]) :
                    route('clinic.show', ['medical_center' => $searchResult['username'], 'uuid' => $searchResult['uuid']]) }}">
                                {{ $searchResult['full_name'] }}</a>
                            @if($searchResult['is_verified']) <i
                                class="fas fa-check-circle text-brand-color"></i> @endif</h3>
                        @if(isset($searchResult['specialities']) && $searchResult['specialities'])
                            <p class="font-light short-specialities">
                                @foreach($searchResult['specialities'] as $speciality)
                                {{ $speciality }},
                                    @if($loop->index >= 1)
                                        <span class="text-xs toggle-specialities cursor-pointer underline">ver más...</span>
                                        @break
                                    @endif
                                    @endforeach</p>
                            <p class="hidden all-specialities">{{ implode(', ', $searchResult['specialities']) }}.
                                <span class="text-xs toggle-specialities cursor-pointer underline">ver menos...</span></p>
                        @endif
                    </div>
                    @if($searchResult['has_online_consultation'])
                        <div class="w-full">
                            <span><i class="fas fa-video mr-2"></i> {{ __('common.has_online_consultation') }}</span>
                        </div>
                    @endif
                </div>
                @if($searchResult['profile_type'] === \App\Models\SpecialistProfile::class && isset($searchResult['addresses']) && count($searchResult['addresses']) > 0)
                <div data-specialist="{{ $searchResult['uuid'] }}">
                    @foreach($searchResult['addresses'] as $key => $address)
                    <a data-consultation="{{ $address['id'] }}"
                        class="{{ $loop->index > 0 ? 'hidden' : '' }} loading inline-flex items-center px-2 py-1 bg-brand-color border border-transparent rounded-md font-medium text-sm text-white tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route(
                       'consultation.create',
                       ['doctor' => $searchResult['uuid'], 'address' => $address['id']]
                       ) }}"
                    >{{ __('common.request_appointment') }}</a>
                    @endforeach
                </div>
                @endif
                @if($searchResult['profile_type'] === \App\Models\ClinicProfile::class)
                <div>
                    <a
                        class="loading inline-flex items-center px-2 py-1 bg-brand-color border border-transparent rounded-md font-medium text-sm text-white tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150"
                       href="{{ route(
                       'clinic.show',
                       ['medical_center' => $searchResult['username'], 'uuid' => $searchResult['uuid']]
                       ) }}"
                    >{{ __('common.view_profile') }}</a>
                </div>
                @endif
            </div>
            @if(isset($searchResult['addresses']) && count($searchResult['addresses']) > 0)
            <div class="flex relative" x-spread="container" x-data="tabs()">
                    <ul class="flex" x-ref="tabs">
                        @foreach($searchResult['addresses'] as $key => $address)
                            <li x-spread="tab" data-ref="{{ $address['id'] }}" data-parent="{{ $searchResult['uuid'] }}" class="transition mr-2 p-2 cursor-pointer">
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
                    @if(isset($searchResult['addresses']) && count($searchResult['addresses']) > 0)
                        @foreach($searchResult['addresses'] as $key => $address)
                            <div data-show="{{ $address['id'] }}" data-hide="{{ $searchResult['uuid'] }}" class="mt-3 transition-all duration-700 {{ $key !== 0 ? 'hidden' : '' }}"
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
