<x-app-layout>
    <div class="">
        <div class="text-right mb-2">
            <a class="text-blue-500" href="{{ route('account.specialists.index', $patient->user->uuid) }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('common.my_specialists_go_back') }}</a>
        </div>
        <div class="grid xl:grid-cols-2 lg:gap-5">
            <div class="">
                <div class="form-card">
                    <div class="flex flex-wrap justify-between">
                        <h2 class="font-bold text-lg mb-4">{{ __('specialists.specialist_data') }}</h2>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4">
                        @if($doctor->prefix_id)
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.prefix") }}</label>
                                <p class="font-medium text-base">{{ $doctor->prefixLabel }}</p>
                            </div>
                        @endif
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                            <p class="font-medium text-base">{{ $doctor->user->first_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                            <p class="font-medium text-base">{{ $doctor->user->last_name }}</p>
                        </div>
                        @if($doctor->license_number)
                            <div class="">
                                <label class="mb-2 text-xs">{{ __("common.license_number") }}</label>
                                <p class="font-medium text-base">{{ $doctor->license_number }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div>
                <div class="w-full overflow-x-auto">
                    <label>{{ __('ratings.show_executed_consultation_copy') }}</label>
                    <table class="w-full whitespace-no-wrap table-fixed mt-2">
                        <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-4 py-3">Consulta</th>
                            <th class="px-4 py-3">Servicio</th>
                            <th class="px-4 py-3">Solicitada el</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 truncate">{{ $rating->consultation->address->title }}</td>
                                <td class="px-4 py-3 truncate">{{ $rating->consultation->service->title }}</td>
                                <td class="px-4 py-3 truncate">{{ $rating->consultation->createdReadable }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($rating->can_change)
            <div class="form-card">
                <h2 class="font-bold text-lg mb-4">{{ __('common.request_rating_title') . ' ' . $doctor->user->first_name }}</h2>
                <form action="{{ route('account.feedback.update', $rating->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <x-rate-specialist :rating="$rating->rating"/>
                    </div>
                    <div class="mb-4">
                        <x-rate-specialist-feedback :rating-feedback="$rating->feedback"/>
                    </div>
                    <div class="mb-4 hidden" id="remarks">
                        <p class="mb-2">{{ __('common.comments') }} ({{ __('common.optional') }})</p>
                        <x-textarea name="remarks" id="remarks">{{ $rating->remarks }}</x-textarea>
                    </div>
                    <div class="text-sm flex justify-between">
                        <button type="button" class="text-brand-color previous hidden">
                            <i class="fas fa-arrow-left mr-2 text-brand-color"></i>{{ __('common.previous') }}</button>
                        <div class="text-right">
                            <x-button type="button" class="next">{{ __('common.next') }} <i class="fas fa-arrow-right"></i></x-button>
                        </div>

                        <x-button class="hidden submit-rating">{{ __('common.update') }}</x-button>
                    </div>
                </form>
                @push('scripts')
                    <script src="{{ asset('js/specialist-rating.js') }}"></script>
                @endpush
            </div>
        @else
            <div class="form-card">
                <h2 class="font-bold text-lg mb-4">{{ __('common.given_rating_title') . ' ' . $doctor->prefixLabel . ' ' . $doctor->user->first_name }}</h2>
                <div class="mb-4">
                    <x-specialist-rating :rating="$rating->rating"/>
                </div>
                <div class="mb-4">
                    <x-show-specialist-feedback :ratingFeedback="$rating->feedback"/>
                </div>
                @if($rating->remarks)
                    <div class="mb-4">
                        <p class="mb-2 font-bold">{{ __('common.comments') }}</p>
                        <p>{{ $rating->remarks }}</p>
                    </div>
                @endif
            </div>
        @endif
        @if(!$rating->dispute)
        <div>
            <p>Si no estás conforme con esta valoración, haz clic
                <span class="text-blue-500 underline cursor-pointer"
                 @click="openModal('#requestDispute')">aquí</span>
                para solicitar una revisión</p>
        </div>
        <livewire:request-rating-dispute :modal="'requestDispute'" :rating="$rating"/>
        @endif
        @if(session('success'))
            <x-toast-alert id="flashMessage">
                {{ session('success') }}
            </x-toast-alert>
        @endif
        @if(session('error'))
            <x-toast-error-alert id="errorMessage">
                {{ session('error') }}
            </x-toast-error-alert>
        @endif
    </div>
</x-app-layout>
