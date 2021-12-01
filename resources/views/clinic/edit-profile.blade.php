<x-app-layout>
    <form action="{{ route('clinic.update', $clinic->username) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if(isset($success))
            <x-alert-success>{{ $success }}</x-alert-success>
        @endif
        @if(!$clinic->email_verified_at)
            <x-alert-notify>
                Aún no has verificado tu cuenta. Por favor, revisa el email con el que te has registrado para completar el proceso de verificación.
                Si no tienes el email, haz click <a class="text-blue-500 underline" href="{{ route('account.send-verification') }}">aquí</a> y te lo volveremos a enviar
            </x-alert-notify>
        @endif
        <div class="form-card">
            <h2 class="font-bold text-xl">Tus datos</h2>
            <div class="relative specialist-avatar mb-4">
                <img src="{{ $clinic->profile->avatarPath }}" id="specialist-avatar" alt="specialist avatar"
                     class="rounded" height="140" width="140">
                <div @click="triggerFileInput('photo-upload')"
                     class="rounded-b text-center cursor-pointer w-full absolute bottom-0 text-white bg-black opacity-60">
                    <small><i
                            class="fas fa-pencil-alt"></i> {{ $clinic->profile->avatar ? __('common.change_picture') : __('common.upload_picture') }}
                    </small></div>
                <input @change="imagePreview('photo-upload', 'specialist-avatar')" type="file" name="profile[avatar]"
                       id="photo-upload" class="hidden">
            </div>
            <div class="mb-4 text-sm">
                <x-label for="volume">{{ __('common.how_many_specialists') }}</x-label>
                <select name="specialists_volume" id="volume" required class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                    <option>{{ __('common.pick_an_option') }}</option>
                    @foreach($specialistsVolume as $volume)
                        <option value="{{ $volume }}" {{ $clinic->profile->specialists_volume == $volume ? 'selected' : '' }}>{{ $volume }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="first_name">{{ __('common.first_name') }} *</x-label>
                <x-input type="text" value="{{ $clinic->first_name }}" id="first_name" name="first_name" placeholder="Pedro"/>
            </div>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('clinics.field_about') }}</h2>
            <p class="font-normal text-base mb-2">Utilice esta sección para mostrar su trayectoria y  logros. Recuerde que los pacientes que buscan una clinica quieren tener el máximo de información posible para tomar una decisión.</p>
            <div class="mb-4 text-sm">
                <x-textarea name="profile[about]" id="about">{{ $clinic->profile->about }}</x-textarea>
            </div>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('clinics.field_offer') }}</h2>
            <p class="font-normal text-base mb-2">Copy faltante.</p>
            <div class="mb-4 text-sm">
                <x-textarea name="profile[our_offer]" id="about">{{ $clinic->profile->our_offer }}</x-textarea>
            </div>
        </div>

        <div class="form-card">
            <h2 class="font-bold text-xl">{{ __('specialities.specialities') }}</h2>
            <p class="font-normal text-base mb-2">{{ __('clinics.choose_specialities') }}.</p>
            <div class="mb-4 text-sm flex">
                @foreach($specialities as $key => $speciality)
                    @if($key == 0 || round(count($specialities) / 2) == $key )
                        <div class="w-full md:w-1/2">
                            @endif
                            <label class="flex items-center mb-1 cursor-pointer">
                                <input type="hidden" name="specialities[{{ $speciality->id }}]" value="0">
                                <input type="checkbox" name="specialities[{{ $speciality->id }}]" value="1"
                                       {{ $clinic->profile->specialities && $clinic->profile->specialities->contains($speciality->id) ? 'checked' : '' }}
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
                                       {{ $clinic->profile->diseases && $clinic->profile->diseases->contains($disease->id) ? 'checked' : '' }}
                                       class="text-brand-color rounded form-checkbox focus:border-brand-color focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray">
                                <span class="ml-2">{{ $disease->title }}</span>
                            </label>
                            @if($key == (count($diseases) - 1) || round(count($diseases) / 2) == ($key + 1))
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @if($social_media)
            <div class="form-card">
                <h2 class="font-bold text-xl">{{ __('social-media.name') }}</h2>
                <p class="font-normal text-base mb-2">{{ __('social-media.sm_copy') }}</p>
                <div class="mb-4 text-sm grid gap-4 sm:grid-cols-2">
                    @foreach($social_media as $media)
                        <div>
                            <label class="flex items-center mb-1 cursor-pointer">{{ $media->name }}</label>
                            <x-input type="text" value="{{
                            !$clinic->socialMedia->isEmpty() && $clinic->socialMedia->contains('id', $media->id)
                            ? $clinic->socialMedia->firstWhere('id', $media->id)->pivot->url
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

        <livewire:specialist-publications :specialist="$clinic"/>
        <livewire:specialist-awards :specialist="$clinic"/>
        <livewire:specialist-languages :specialist="$clinic"/>

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
