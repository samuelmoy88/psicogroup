<div class="px-4 py-5">
    <div class="bg-white border-b border-gray-200 pb-4 mb-4">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            {{ __('clinics.invite_specialist_title') }}
        </h3>
        <p class="mt-1 text-sm text-gray-500">
            {{ __('clinics.invite_specialist_subtitle') }}
        </p>
    </div>
    <div class="mb-4">
        <p class="mt-1 text-sm text-gray-500 mb-2">
            {{ __('clinics.find_specialist_expanded') }}
        </p>
        <div class="mb-5">
            <x-input autofocus type="text" wire:model.debounce.500ms="q" {{--wire:change.debounce.500ms="$emit('findSpecialist')"--}} wire:keydown.enter="$emit('findSpecialist')" id="specialist" placeholder="Por ejemplo: Gonzalo Martínez"/>
        </div>
        @if(!is_null($specialists) && !$specialists->isEmpty())
        <div class="mb-5">
        <ul role="list" class="-my-5 divide-y divide-gray-200">
        @foreach($specialists as $specialist)
                <li class="py-4 cursor-pointer">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8 rounded-full" src="{{ $specialist->profile->avatarPath }}" alt="Specialist photo">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">
                               {{ $specialist->profile->prefixLabel }} {{ $specialist->first_name }} {{ $specialist->last_name }}
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                {{ $specialist->profile->license_number }}
                            </p>
                        </div>
                        <div>
                            @if($clinic->profile->canSpecialistBeInvited($specialist) && !array_key_exists($specialist->id, $invitationsList))
                            <button class="bg-brand-color text-white inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full hover:bg-gray-50"
                                    wire:click="$emit('addToInvitationList', {{$specialist->profile_id}}, ['{{$specialist->profile->prefixLabel}}','{{$specialist->first_name}}', '{{$specialist->last_name}}'])">
                                {{ __('common.add') }}
                            </button>
                            @else
                                <span class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50">
                                    {{ __('clinics.invitation_sent') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
        </div>
        @endif
        @if($q && $noResults)
        <div class="mt-6">
            <a href="#" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                {{ __('clinics.specialist_not_found') }}
            </a>
        </div>
        @endif
        @if(count($invitationsList) > 0)
            <div class="flex flex-wrap space-x-2">
                @foreach($invitationsList as $id => $invitation)
                    <p class="inline-flex rounded-full items-center py-0.5 pl-2.5 pr-1 text-sm font-medium bg-indigo-100 text-indigo-700">
                      {{ implode(' ', $invitation) }}
                      <button type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                        <span class="sr-only">Remove large option</span>
                        <svg class="h-2 w-2" wire:click="$emit('removeFromInvitationList', {{ $id }})" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                          <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                        </svg>
                      </button>
                    </p>
                @endforeach
            </div>
            <div class="mt-4 text-right">
                <button wire:click="$emit('sendInvitations')" type="button" class="inline-flex items-center px-4 py-2 bg-brand-color border border-transparent rounded-md font-medium text-white tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                    {{ __('clinics.send_invitations') }}
                </button>
            </div>
        @endif
    </div>
</div>
