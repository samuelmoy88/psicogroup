<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('specialists.clinics_list') }}</h2>
            <button class="text-blue-500"
                    onclick="Livewire.emit('openModal', 'create-specialist-clinic-modal')">{{ __('specialists.add_clinics') }}</button>
        </div>
        @if(count($clinics) > 0)
            <ul class="addresses">
                @foreach($clinics as $clinic)
                    <li class="block hover:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="flex-shrink-0">
                                    <a href="{{ route('clinic.show', ['medical_center' => $clinic->user->username, 'uuid' => $clinic->user->uuid]) }}">
                                        <img class="object-cover h-12 w-12 rounded-full"
                                             src="{{ $clinic->avatarPath }}" alt="">
                                    </a>
                                </div>
                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-4 md:gap-4 md:justify-center">
                                    <div>
                                        <a href="{{ route('clinic.show', ['medical_center' => $clinic->user->username, 'uuid' => $clinic->user->uuid]) }}"
                                           class="text-sm font-medium text-indigo-600 truncate">{{ $clinic->prefixLabel }} {{ $clinic->user->fullName }}</a>
                                        <p class="mt-2 flex items-center text-sm text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                            </svg>
                                            <span class="truncate">{{ $clinic->user->email }}</span>
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <div class="flex flex-wrap items-center">
                                            <p class="text-sm text-gray-900 flex-1-full">
                                                {{ $clinic->pivot->started_by === App\Models\ClinicProfile::class ? __('specialists.clinic_invited_at') : __('specialists.request_sent_at') }}
                                                <time
                                                    datetime="{{ $clinic->pivot->created_at->locale('es_ES')->format('j \\d\\e F Y') }}"
                                                >{{ $clinic->pivot->created_at->locale('es_ES')->format('j \\d\\e F Y') }}</time>
                                            </p>
                                            <div class="mt-2 flex items-center text-sm text-gray-500 justify-between flex-1">
                                                <span>{{ __('clinics.' . $clinic->pivot->state) }}</span>
                                                @if($clinic->pivot->started_by === App\Models\SpecialistProfile::class && $clinic->pivot->state === \App\Models\ClinicSpecialist::SPECIALIST_STATE_PENDING)
                                                    <form class="inline-flex"
                                                          action="{{ route('specialist.invitations.resend', $clinic->user->uuid) }}"
                                                          method="post">
                                                        @csrf
                                                        <input type="hidden" name="invitation_token"
                                                               value="{{ $clinic->pivot->invitation_token }}">
                                                        <button type="submit"
                                                                class="ml-4 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-brand-color text-white">
                                                            {{ __('clinics.resend_invitation') }}
                                                        </button>
                                                    </form>
                                                @endif
                                                @if($clinic->pivot->started_by === App\Models\ClinicProfile::class && $clinic->pivot->state === \App\Models\ClinicSpecialist::SPECIALIST_STATE_PENDING)
                                                    <div class="text-right">
                                                        <a href="{{ route('specialist.clinics.accept', ['uuid' => auth()->user()->uuid ,'token' => $clinic->pivot->invitation_token]) }}"
                                                           class="mr-2 cursor-pointer text-blue-500 underline">{{ __('common.accept') }}</a>
                                                        <a href="{{ route('specialist.clinics.reject', ['uuid' => auth()->user()->uuid ,'token' => $clinic->pivot->invitation_token]) }}"
                                                         class="text-red-500 underline cursor-pointer">{{ __('common.reject') }}</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @if($clinic->pivot->state === App\Models\ClinicSpecialist::SPECIALIST_STATE_ACCEPTED)
                                    <div>
                                        {{ $clinic->pivot->is_premium ? __('clinics.premium_is_able') : __('clinics.premium_is_disabled') }}
                                    </div>
                                    @endif
                                    <div>
                                        <button onclick='Livewire.emit("openModal", "delete-specialist-clinic", @json(['clinicSpecialist' => $clinic]))'
                                                class="ml-4 inline-flex items-center text-red-500">
                                            <i class="fas fa-trash-alt" aria-hidden="true" title="{{ __('specialists.delete_clinic') }}"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <div>No perteneces al equipo de ningún centro médico, haz click
                <button onclick="Livewire.emit('openModal', 'create-specialist-clinic-modal')" class="text-blue-500">
                    aquí
                </button>
                para solicitar unirte
            </div>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
    @if (session('error'))
        <x-toast-error-alert id="errorMessageSession">
            {{ session('error') }}
        </x-toast-error-alert>
    @endif
    @if ($errors->any())
        <x-toast-error-alert id="errorMessage">
            {{ __('clinics.resend_invitation_error') }}
        </x-toast-error-alert>
    @endif
    @push('scripts')
        <script>
            let premiumToggleCheckboxes = document.querySelectorAll('.toggle_premium');
            if (premiumToggleCheckboxes.length > 0 ) {
                for(let i of premiumToggleCheckboxes) {
                    i.addEventListener('click', function () {
                        fetch(this.dataset.route, {
                            method: 'PUT',
                            mode: 'cors',
                            cache: 'no-cache',
                            headers: {
                                "Content-Type": "application/json",
                                "Accept": "application/json, text-plain, */*",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            }
                        });
                    });
                }
            }
        </script>
    @endpush
</x-app-layout>
