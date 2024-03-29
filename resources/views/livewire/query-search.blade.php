<div>
    <input class="text-center border-gray-100 rounded w-full py-3 px-12 xl:px-20" type="text"
           value="$query" placeholder="Especialidad"
           wire:focusout="$emit('refreshComponent')"
           wire:keydown.escape="$emit('refreshComponent')"
           wire:keydown.tab="$emit('refreshComponent')"
           wire:click="$emit('baseSearch')"
           wire:model.debounce.700ms="query"
           wire:keydown.enter.prevent="$emit('autofillSelection')"
    />
    <input type="hidden" name="service[]" wire:model="service" value="$service">
    <input type="hidden" name="speciality[]" wire:model="speciality" value="$speciality">
    <input type="hidden" name="disease[]" wire:model="disease" value="$disease">
    <input type="hidden" name="query" wire:model="query" value="$query">
    <input type="hidden" name="profile" wire:model="profile" value="$profile">
    <div class="relative">
        <div wire:loading>
            <ul class="search_dropdown">
                <li class="flex flex-wrap justify-between w-full py-3 px-3 flex border-gray-300 cursor-pointer hover:bg-gray-100">
                    {{ __('common.searching...') }}</li>
            </ul>
        </div>
        @if(!$query)
            @if(count($baseSearch) > 0)
                <ul class="search_dropdown">
                    @foreach($baseSearch as $type => $searches)
                        @foreach($searches as $key => $_search)
                            <li wire:click="$emit('fillQuery', '{{$_search['title']}}', '{{ $type }}', '{{ $_search['id'] }}')"
                                class="flex flex-wrap justify-between w-full py-3 px-3
                                    flex border-gray-300 cursor-pointer hover:bg-gray-100">
                                <div class="">{{ $_search['title'] }}</div>
                                <span class="text-gray-400 text-xs">{{ __('common.'.$type) }}</span>
                            </li>
                        @endforeach
                    @endforeach
                </ul>
            @endif
        @else
            <ul class="search_dropdown">
                @if(strlen($query) >= 3)
                    <li wire:click="$emit('setProfile', 'specialist')"
                        class="flex fle-wrap justify-between w-full py-3 px-3 flex border-gray-300 cursor-pointer hover:bg-gray-100">
                    {{ __('common.to_search') }} "{{ $query }}" {{ __('common.in_specialists') }}</li>
                    <li wire:click="$emit('setProfile', 'clinic')"
                        class="flex flex-wrap justify-between w-full py-3 px-3 flex border-gray-300 cursor-pointer hover:bg-gray-100">
                    {{ __('common.to_search') }} "{{ $query }}" {{ __('common.in_clinics') }}</li>
                @endif
                @if(count($search) > 0)
                    @foreach($search as $type => $searches)
                        @if(in_array($type, ['services', 'specialities', 'diseases']))
                            @foreach($searches as $key => $_search)
                                <li wire:click="$emit('fillQuery', '{{$_search['title']}}', '{{ $type }}', '{{ $_search['id'] }}')"
                                    class="flex flex-wrap justify-between w-full py-3 px-3
                                        flex border-gray-300 cursor-pointer hover:bg-gray-100">
                                    <div class="">{{ $_search['title'] }}</div>
                                    <span class="text-gray-400 text-xs">{{ __('common.'.$type) }}</span>
                                </li>
                            @endforeach
                        @else
                            @foreach($searches as $key => $_search)
                                <li class="w-full py-3 px-3 flex border-gray-300 cursor-pointer hover:bg-gray-100">
                                    <a href="{{ $_search['profile_type'] == App\Models\SpecialistProfile::class ?
                                    route('specialist.show', ['specialist' => $_search['username'], 'uuid' => $_search['uuid']]) :
                                    route('clinic.show', ['medical_center' => $_search['username'], 'uuid' => $_search['uuid']]) }}"
                                       class="flex flex-wrap justify-between w-full">
                                        {{--<div class="flex items-center text-sm">
                                        <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full" src="{{ $search->profile->avatarPath }}" alt="" loading="lazy">
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                        </div>
                                    </div>--}}
                                        <div class="">
                                            {{ $_search['first_name'] . ' ' . $_search['last_name'] }}
                                            {!! isset($_search['title']) ? "<p class='text-gray-400 text-xs'>{$_search['title']}</p>" : "" !!}
                                        </div>
                                        <span class="text-gray-400 text-xs">{{ isset($_search['profile_type']) ? __('common.'.$_search['profile_type']) : __('common.'.$type) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </ul>
        @endif
    </div>
</div>
