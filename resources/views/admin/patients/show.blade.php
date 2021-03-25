<x-admin-layout>
    <div class="">
        <div class="text-right mb-2">
            <a class="text-blue-500" href="{{ route('patients.index') }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('patients.go_back') }}</a>
        </div>
        <div class="grid xl:grid-cols-2 lg:gap-5">
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('specialists.specialist_data') }}</h2>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                            <p class="font-medium text-base">{{ $patient->first_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                            <p class="font-medium text-base">{{ $patient->last_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.email") }}</label>
                            <p class="font-medium text-base">{{ $patient->email }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.phone") }}</label>
                            <p class="font-medium text-base">{{ $patient->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('common.consultations_history') }}</h2>
                    </div>
                    <div>
                        @if(count($patient->profile->consultations) > 0)
                            <div class="table striped hovered">
                                <div class="thead">
                                    <div class="tr">
                                        <div class="td">Especialista</div>
                                        <div class="td">Fecha</div>
                                    </div>
                                </div>
                                <div class="tbody">
                                    @foreach($patient->profile->consultations as $consultation)
                                        <div class="tr">
                                            <div class="td">
                                                {{ $patient->profile->specialists->firstWhere('profile_id', $consultation->patient_profile_id)->first_name }}
                                                {{ $patient->profile->specialists->firstWhere('profile_id', $consultation->patient_profile_id)->last_name }}</div>
                                            <div class="td">{{ $consultation->createdReadable }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
