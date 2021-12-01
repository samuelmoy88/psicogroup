<x-app-layout>
    <form action="{{ route('specialist.update', $specialist->username) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if(isset($success))
            <x-alert-success>{{ $success }}</x-alert-success>
        @endif
        @if(!$specialist->email_verified_at)
            <x-alert-notify>
                Aún no has verificado tu cuenta. Por favor, revisa el email con el que te has registrado para completar el proceso de verificación.
                Si no tienes el email, haz click <a class="text-blue-500 underline" href="{{ route('account.send-verification') }}">aquí</a> y te lo volveremos a enviar
            </x-alert-notify>
        @endif
        <div class="form-card">
            <h2 class="font-bold text-xl">Tus datos</h2>
            <div class="relative specialist-avatar mb-4">
                <img src="{{ $specialist->profile->avatarPath }}" id="specialist-avatar" alt="specialist avatar"
                     class="rounded" height="140" width="140">
                <div @click="triggerFileInput('photo-upload')"
                     class="rounded-b text-center cursor-pointer w-full absolute bottom-0 text-white bg-black opacity-60">
                    <small><i
                            class="fas fa-pencil-alt"></i> {{ $specialist->profile->avatar ? __('common.change_picture') : __('common.upload_picture') }}
                    </small></div>
                <input @change="imagePreview('photo-upload', 'specialist-avatar')" type="file" name="profile[avatar]"
                       id="photo-upload" class="hidden">
            </div>
            <div class="mb-4 text-sm">
                <x-label for="prefix">{{ __('common.prefix') }}</x-label>
                <x-select-options name="profile[prefix_id]" id="prefix" :value="$specialist->profile->prefix_id"
                                  :placeholder="'Elegir'" :options="$prefixes"/>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="first_name">{{ __('common.first_name') }} *</x-label>
                <x-input type="text" value="{{ $specialist->first_name }}" id="first_name" name="first_name" placeholder="Pedro"/>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="last_name">{{ __('common.last_names') }} *</x-label>
                <x-input type="text" value="{{ $specialist->last_name }}" id="last_name" name="last_name" placeholder="Perez"/>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="license_number">{{ __('common.license_number') }} </x-label>
                <x-input type="text" value="{{ $specialist->profile->license_number }}" id="license_number"
                         name="profile[license_number]"/>
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('specialists.field_about') }}</h2>
            <p class="font-normal text-base mb-2">Utilice esta sección para mostrar su experiencia y sus logros. Recuerde que los pacientes que buscan un especialista quieren tener el máximo de información posible para tomar una decisión.</p>
            <div class="mb-4 text-sm">
                <x-textarea name="profile[about]" id="about">{{ $specialist->profile->about }}</x-textarea>
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('specialities.specialities') }}</h2>
            <p class="font-normal text-base mb-2">{{ __('specialities.specialities_choose') }}.</p>
            <div class="mb-4 text-sm flex">
                @foreach($specialities as $key => $speciality)
                    @if($key == 0 || round(count($specialities) / 2) == $key )
                    <div class="w-full md:w-1/2">
                    @endif
                    <label class="flex items-center mb-1 cursor-pointer">
                        <input type="hidden" name="specialities[{{ $speciality->id }}]" value="0">
                        <input type="checkbox" name="specialities[{{ $speciality->id }}]" value="1"
                               {{ $specialist->profile->specialities && $specialist->profile->specialities->contains($speciality->id) ? 'checked' : '' }}
                               class="text-brand-color rounded form-checkbox focus:border-brand-color focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                        <span class="ml-2">{{ $speciality->title }}</span>
                    </label>
                    @if($key == (count($specialities) - 1) || round(count($specialities) / 2) == ($key + 1))
                    </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('diseases.diseases') }}</h2>
            <p class="font-normal text-base mb-2">{{ __('diseases.treatments_copy') }}.</p>
            <div class="mb-4 text-sm flex">
                @foreach($diseases as $key => $disease)
                    @if($key == 0 || round(count($diseases) / 2) == $key )
                        <div class="w-full md:w-1/2">
                            @endif
                            <label class="flex items-center mb-1 cursor-pointer">
                                <input type="hidden" name="diseases[{{ $disease->id }}]" value="0">
                                <input type="checkbox" name="diseases[{{ $disease->id }}]" value="1"
                                       {{ $specialist->profile->diseases && $specialist->profile->diseases->contains($disease->id) ? 'checked' : '' }}
                                       class="text-brand-color rounded form-checkbox focus:border-brand-color focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <span class="ml-2">{{ $disease->title }}</span>
                            </label>
                            @if($key == (count($diseases) - 1) || round(count($diseases) / 2) == ($key + 1))
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        @if(count($uneasiness) > 0)
        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('uneasiness.uneasiness') }}</h2>
            <p class="font-normal text-base mb-2">{{ __('uneasiness.uneasiness_copy') }}</p>
            <div class="mb-4 text-sm flex">
                @foreach($uneasiness as $key => $unease)
                    @if($key == 0 || round(count($uneasiness) / 2) == $key )
                        <div class="w-full md:w-1/2">
                            @endif
                            <label class="flex items-center mb-1 cursor-pointer">
                                <input type="hidden" name="uneasiness[{{ $unease->id }}]" value="0">
                                <input type="checkbox" name="uneasiness[{{ $unease->id }}]" value="1"
                                       {{ $specialist->uneasiness && $specialist->uneasiness->contains($unease->id) ? 'checked' : '' }}
                                       class="text-brand-color rounded form-checkbox focus:border-brand-color focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <span class="ml-2">{{ $unease->title }}</span>
                            </label>
                            @if($key == (count($uneasiness) - 1) || round(count($uneasiness) / 2) == ($key + 1))
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        @if($social_media)
            <div class="form-card">
                <h2 class="font-bold text-xl">{{ __('social-media.name') }}</h2>
                <p class="font-normal text-base mb-2">{{ __('social-media.sm_copy') }}</p>
                <div class="mb-4 text-sm grid gap-4 sm:grid-cols-2">
                    @foreach($social_media as $media)
                        <div>
                            <label class="flex items-center mb-1 cursor-pointer">{{ $media->name }}</label>
                            <x-input type="text" value="{{
                            !$specialist->socialMedia->isEmpty() && $specialist->socialMedia->contains('id', $media->id)
                            ? $specialist->socialMedia->firstWhere('id', $media->id)->pivot->url
                            : ''
                            }}" name="social_media[{{ $media->id }}]"/>
                        </div>
                    @endforeach
                </div>
                @if(!auth()->user()->profile->isPremium())
                    <x-premium-sponsor-block title="{{ __('social-media.sm_premium_copy_title') }}" subtitle="{{ __('social-media.sm_premium_copy_subtitle') }}"/>
                @endif
            </div>
        @endif

        <livewire:specialist-education :specialist="$specialist"/>
        <livewire:specialist-publications :specialist="$specialist"/>
        <livewire:specialist-awards :specialist="$specialist"/>
        <livewire:specialist-certificates :specialist="$specialist"/>
        <livewire:specialist-experiences :specialist="$specialist"/>
        <livewire:specialist-languages :specialist="$specialist"/>
        <div class="mb-4 text-sm text-right">
            <x-button>{{ __('common.save_changes') }}</x-button>
        </div>
    </form>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-app-layout>
