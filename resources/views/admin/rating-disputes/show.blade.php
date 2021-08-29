<x-admin-layout>
    <div class="">
        <div class="flex flex-wrap justify-between">
            <h2 class="font-bold text-lg mb-4">
                Esta disputa ha sido solicitada por {{ $dispute->createdBy }}
            </h2>
            <div class="text-right mb-2">
                <a class="text-blue-500" href="{{ route('rating-dispute.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('rating-dispute.rating_disputes_go_back') }}</a>
            </div>
        </div>
        <div class="grid xl:grid-cols-2 lg:gap-5">
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('patients.patient_data') }}</h2>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                            <p class="font-medium text-base">{{ $dispute->rating->patient->user->first_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                            <p class="font-medium text-base">{{ $dispute->rating->patient->user->last_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.phone") }}</label>
                            <p class="font-medium text-base">{{ $dispute->rating->patient->user->phone }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.email") }}</label>
                            <p class="font-medium text-base">{{ $dispute->rating->patient->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('specialists.specialist_data') }}</h2>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        @if($dispute->rating->specialist->prefix_id)
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.prefix") }}</label>
                                <p class="font-medium text-base">{{ $dispute->rating->specialist->prefixLabel }}</p>
                            </div>
                        @endif
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                            <p class="font-medium text-base">{{ $dispute->rating->specialist->user->first_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                            <p class="font-medium text-base">{{ $dispute->rating->specialist->user->last_name }}</p>
                        </div>
                        @if($dispute->rating->specialist->license_number)
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.license_number") }}</label>
                                <p class="font-medium text-base">{{ $dispute->rating->specialist->license_number }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-lg mb-4">{{ __('common.consultation_data') }}</h2>
            </div>
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap table-fixed">
                    <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Consulta</th>
                        <th class="px-4 py-3">Servicio</th>
                        <th class="px-4 py-3">Solicitada el</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    @foreach($dispute->rating->patient->executedConsultations as $consultation)
                        <tr class="text-gray-700 dark:text-gray-400">
                            <td class="px-4 py-3 truncate">{{ $consultation->address->title }}</td>
                            <td class="px-4 py-3 truncate">{{ $consultation->service->title }}</td>
                            <td class="px-4 py-3 truncate">{{ $consultation->createdReadable }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-card">
            <h2 class="font-bold text-lg mb-4">{{ __('rating-dispute.received_rating') . ' ' . $dispute->rating->specialist->user->first_name }}</h2>
            <div class="mb-4">
                <div class="flex space-x-2">
                    <x-specialist-rating :rating="$dispute->rating->rating"/>
                </div>
            </div>
            @if($dispute->rating->remarks)
                <div class="mb-4">
                    <p class="mb-2">{{ __('common.comments') }}</p>
                    <p>{{ $dispute->rating->remarks }}</p>
                </div>
            @endif
        </div>
        @if($dispute->user_feedback)
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-lg mb-4">{{ __('ratings.user_feedback') }}</h2>
            </div>
            <div class="w-full overflow-x-auto">
                <p>{{ $dispute->user_feedback }}</p>
            </div>
        </div>
        @endif
        @if($dispute->canBeChanged())
        <div>
            <livewire:change-rating-dispute-state :dispute="$dispute"/>
        </div>
        @else
            {{ __('rating-dispute.rating_resolved_and_time_expired') }}
        @endif
    </div>
</x-admin-layout>
