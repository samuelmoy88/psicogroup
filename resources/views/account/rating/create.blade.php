<x-app-layout>
    <div class="">
        <form action="{{ route('account.feedback.store', ['patient' => $patient->uuid, 'doctor' => $doctor->uuid]) }}"
              method="post">
            @csrf
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
                               href="{{ route('specialist.show', ['specialist' => $doctor->username, 'uuid' => $doctor->uuid]) }}">
                                {{ __('common.view_profile') }}</a>
                        </div>
                        <div class="grid sm:grid-cols-3 gap-4">
                            @if($doctor->profile->prefix_id)
                                <div class="">
                                    <label class="mb-2 text-xs">{{ __("common.prefix") }}</label>
                                    <p class="font-medium text-base">{{ $doctor->profile->prefixLabel }}</p>
                                </div>
                            @endif
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                                <p class="font-medium text-base">{{ $doctor->first_name }}</p>
                            </div>
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                                <p class="font-medium text-base">{{ $doctor->last_name }}</p>
                            </div>
                            @if($doctor->profile->license_number)
                                <div class="">
                                    <label class="mb-2 text-xs">{{ __("common.license_number") }}</label>
                                    <p class="font-medium text-base">{{ $doctor->profile->license_number }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div>
                    <div class="w-full overflow-x-auto">
                        <label class="mb-2"
                               for="consultation_id">{{ __('ratings.select_executed_consultation_copy') }}</label>
                        <select name="consultation_id" id="consultation_id"
                                class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                            <option value="" selected>{{ __('ratings.select_executed_consultation') }}</option>
                            @foreach($patient->profile->executedConsultations as $consultation)
                                <option value="{{ $consultation->id }}"
                                >Consulta: {{ $consultation->address->title }} |
                                    Servicio: {{ $consultation->service->title }} |
                                    Fecha: {{ $consultation->createdReadable }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-card">
                <h2 class="font-bold text-lg mb-4">{{ __('common.request_rating_title') . ' ' . $doctor->first_name }}</h2>
                <div class="mb-4">
                    <x-rate-specialist/>
                </div>
                <div class="mb-4">
                    <x-rate-specialist-feedback/>
                </div>
                <div class="mb-4 hidden" id="remarks">
                    <p class="mb-2">{{ __('common.comments') }} ({{ __('common.optional') }})</p>
                    <x-textarea name="remarks" id="remarks"></x-textarea>
                </div>
                <div class="text-sm flex justify-between">
                    <button type="button" class="text-brand-color previous hidden">
                        <i class="fas fa-arrow-left mr-2 text-brand-color"></i>{{ __('common.previous') }}</button>
                    <div class="text-right">
                        <x-button type="button" class="next">{{ __('common.next') }} <i class="fas fa-arrow-right"></i>
                        </x-button>
                    </div>

                    <x-button class="hidden submit-rating">{{ __('common.update') }}</x-button>
                </div>
            </div>
        </form>
    </div>
    @push('scripts')
        <script src="{{ asset('js/specialist-rating.js') }}"></script>
    @endpush
</x-app-layout>
