<x-app-layout>
    <div class="mb-2">
        <nav>
            <ul class="flex space-x-2 text-xs profile-breadcrumbs">
                <li>
                    <a href="/" class="underline">{{ __('common.home') }}</a>
                </li>
                @if(!$clinic->profile->specialities->isEmpty())
                    <li class="">
                        @foreach($clinic->profile->specialities as $specialities)
                            <a href="/search?speciality[]={{ $specialities->id }}" class="underline breadcrumbs-specialities">{{ $specialities->title }}</a>
                            @if($loop->index === 2) @break @endif
                        @endforeach
                    </li>
                @endif
                @if(!$clinic->addresses->isEmpty())
                    <li>
                        @foreach($clinic->addresses as $address)
                            @if($address->city)
                                @if($loop->index > 0) @break @endif
                                <a href="/search?location={{ $address->city }}" class="underline">{{ $address->city }}</a>
                            @endif
                        @endforeach
                    </li>
                @endif
                <li>
                    {{ $clinic->profile->prefixLabel }} {{ $clinic->first_name }} {{ $clinic->last_name }}
                </li>
            </ul>
        </nav>
    </div>
    <div class="form-card sm:w-2/3 mb-4">
        <div class="flex">
            <div class="specialist-avatar mb-4 mr-4">
                <img src="{{ $clinic->profile->avatarPath }}" id="specialist-avatar" alt="specialist avatar"
                     class="rounded" height="140" width="140">
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold">{{ $clinic->profile->prefixLabel }} {{ $clinic->first_name }} {{ $clinic->last_name }}
                    @if($clinic->profile->is_verified) <i class="fas fa-check-circle text-brand-color"></i>@endif</h3>
                @if($clinic->profile->license_number)
                    <p class="text-xs mt-3 mb-2">{{ __('common.license_number') }}</p>
                    <p class="text-sm">{{ $clinic->profile->license_number }}</p>
                @endif
            </div>
        </div>
        <hr>
        <div class="xs:overflow-x-auto mb-4 relative" x-spread="container" x-data="tabs()">
            <ul class="flex" x-ref="tabs">
                @if(!$clinic->profile->specialities->isEmpty() || $clinic->profile->diseases->isEmpty() || $clinic->profile->hasPremuimPerks())
                    <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                        {{ __('common.info') }}</li>
                @endif
                @if(!$clinic->profile->activeSpecialists->isEmpty())
                    <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                        {{ __('common.specialists') }}</li>
                @endif
                @if(!$clinic->profile->specialistsRatings->isEmpty())
                    <li x-spread="tab" class="transition mr-2 p-2 cursor-pointer">
                        {{ __('common.ratings') }}
                    </li>
                @endif
                <div x-spread="indicator" class="border-t-2 border-brand-color-top absolute left-0 bottom-0 transition-all duration-500"></div>
            </ul>
        </div>
    </div>
    <div x-ref="cards">
        @if(!$clinic->profile->specialities->isEmpty() || !$clinic->profile->diseases->isEmpty() || $clinic->profile()->hasPremuimPerks())
            <div class="">
                <div class="form-card sm:w-2/3 mb-4">
                    <div class="mb-4 flex flex-wrap">
                        <span class="w-full text-gray-500"><i class="fas fa-stethoscope mr-4"></i>Consultas</span>
                        <div class="bg-white flex-grow">
                            <ul class="shadow-box divide-y divide-gray-200">
                                @foreach($clinic->addresses as $address)
                                    <li class="relative">
                                        <div class="pl-6 my-3 flex items-center justify-between">
                                            <span>{{ $address->clinic_name ? $address->clinic_name . ' - ' : '' }} {{ $address->title }}</span>
                                        </div>
                                        <div class="relative transition-all" style="">
                                            <div class="pl-6 my-2">
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
                                                        <a href="{{ $address->getWebSite() }}" class="underline text-blue-500" target="_blank" rel="noreferrer noopener">{{ $address->web_site }}</a>
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
                    </div>
                </div>
                @if ($clinic->profile->about)
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-address-card mr-5 flex-shrink text-gray-500"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('clinics.field_about') }}</p>
                                <p class="text-black">{{ $clinic->profile->about }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($clinic->profile->our_offer)
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="far fa-bookmark mr-5 flex-shrink text-gray-500"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('clinics.field_offer') }}</p>
                                <p class="text-black">{{ $clinic->profile->our_offer }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->profile->specialities->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-book-medical mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('common.our_specialities') }}</p>
                                <ul class="shadow-box list-disc pl-4">
                                    @foreach($clinic->profile->specialities as $specialities)
                                        <li class="relative" x-data="{selected:null}">
                                            <span>{{ $specialities->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->profile->diseases->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-viruses mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('common.treated_diseases') }}</p>
                                <ul class="shadow-box list-disc pl-4">
                                    @foreach($clinic->profile->diseases as $diseases)
                                        <li class="relative" x-data="{selected:null}">
                                            <span>{{ $diseases->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->profile->servicesViaSpecialists()->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-hand-holding-medical mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('clinics.services_we_offer') }}</p>
                                <ul class="shadow-box list-disc pl-4">
                                    @foreach($clinic->profile->servicesViaSpecialists() as $service)
                                        <li class="relative" x-data="{selected:null}">
                                            <span>{{ $service->title }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->profile->publication->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-newspaper mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('common.publications') }}</p>
                                <ul class="shadow-box list-disc pl-4">
                                    @foreach($clinic->profile->publication as $publication)
                                        <li class="relative" x-data="{selected:null}">
                                            <span>{!! $publication->fullLabel !!}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->profile->awards->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-medal mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('common.awards') }}</p>
                                <ul class="shadow-box list-disc pl-4">
                                    @foreach($clinic->profile->awards as $award)
                                        <li class="relative" x-data="{selected:null}">
                                            <span>{{ $award->fullLabel }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->profile->languages->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-language mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('common.languages') }}</p>
                                <ul class="shadow-box list-disc pl-4">
                                    <li class="relative" x-data="{selected:null}">
                                        <span>{{ $clinic->profile->getLanguagesLabels() }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!$clinic->socialMedia->isEmpty())
                    <div class="form-card sm:w-2/3 mb-4">
                        <div class="mb-4 flex flex-start items-start">
                            <i class="fas fa-share-alt mr-5 flex-shrink text-gray-500" aria-hidden="true"></i>
                            <div class="flex-grow">
                                <p class="w-full font-light leading-none mb-5 text-gray-500">{{ __('common.social_media') }}</p>
                                <ul class="shadow-box flex space-x-2">
                                    @foreach($clinic->socialMedia as $socialMedia)
                                        <li class="relative" x-data="{selected:null}">
                                            <a href="{{ $socialMedia->pivot->url }}" target="_blank" rel="noopener">@include('components.' .strtolower($socialMedia->name))</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
        @if(!$clinic->profile->activeSpecialists->isEmpty())
            <div class="form-card sm:w-2/3 mb-4 hidden">
                <ul class="divide-y divide-gray-200">
                    @foreach($clinic->profile->activeSpecialists as $specialist)
                        <li class="block hover:bg-gray-50">
                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('specialist.show', ['specialist' => $specialist->user->username, 'uuid' => $specialist->user->uuid]) }}">
                                            <img class="object-cover h-16 w-16 rounded-full"
                                                 src="{{ $specialist->avatarPath }}" alt="">
                                        </a>
                                    </div>
                                    <div class="min-w-0 flex-1 px-4 flex flex-col space-y-2">
                                        <div>
                                            <a href="{{ route('specialist.show', ['specialist' => $specialist->user->username, 'uuid' => $specialist->user->uuid]) }}"
                                               class="text-sm font-medium text-indigo-600 truncate">{{ $specialist->prefixLabel }} {{ $specialist->user->fullName }}</a>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 space-x-2">
                                                <x-specialist-rating-no-text :rating="$specialist->averageRating()"/>
                                                <span class="truncate">{{ $specialist->totalRating() }} {{ __('common.ratings') }}</span>
                                            </div>
                                        </div>
                                        <div class="block">
                                            <a href="{{ route('specialist.show', ['specialist' => $specialist->user->username, 'uuid' => $specialist->user->uuid]) }}"
                                                class="inline-flex items-center px-2 py-1 bg-brand-color border border-transparent rounded-md font-medium text-sm text-white focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                                                Ver perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!$clinic->profile->activeSpecialistsRatings->isEmpty())
            <div class="form-card sm:w-2/3 mb-4 hidden">
                @foreach($clinic->profile->activeSpecialistsRatings as $rating)
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
                                |
                                {{ $rating->specialist->prefixLabel }} {{ $rating->specialist->user->fullName }}
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
                                    <img class="object-cover h-10 w-10 rounded-full" src="{{ $clinic->profile->avatarPath }}" alt="" loading="lazy">
                                </div>
                            </div>
                        @endif
                        <hr class="border-t-2 border-gray-2 my-4">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
