<x-admin-layout>
    <div class="">
        <div class="text-right mb-2">
            <a class="text-blue-500" href="{{ route('doctors.index') }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('specialists.go_back') }}</a>
        </div>
        <div class="grid xl:grid-cols-2 lg:gap-5">
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('specialists.specialist_data') }}</h2>
                        <a class="text-blue-500"
                           target="_blank" rel="noopener"
                           href="https://psico-group.com{{ route('specialist.show', ['specialist' => $specialist->username, 'uuid' => $specialist->uuid], false) }}">
                            {{ __('common.view_profile') }}</a>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        @if($specialist->profile->prefix_id)
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.prefix") }}</label>
                                <p class="font-medium text-base">{{ $specialist->profile->prefixLabel }}</p>
                            </div>
                        @endif
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                            <p class="font-medium text-base">{{ $specialist->first_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                            <p class="font-medium text-base">{{ $specialist->last_name }}</p>
                        </div>
                        @if($specialist->profile->license_number)
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.license_number") }}</label>
                                <p class="font-medium text-base">{{ $specialist->profile->license_number }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                @if(count($specialist->addresses) > 0)
                    @include('admin.specialists._addresses')
                @endif
                @if(count($specialist->profile->services) > 0)
                    @include('admin.specialists._services')
                @endif
            </div>
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('common.latest_changes') }}</h2>
                    </div>
                    <livewire:specialist-changes :specialist="$specialist"/>
                </div>
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('common.consultations_history') }}</h2>
                    </div>
                    <livewire:specialist-consultations :specialist="$specialist"/>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
