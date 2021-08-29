<x-app-layout>
    <div class="">
        <div class="text-right mb-2">
            <a class="text-blue-500" href="{{ route('specialist.ratings.index', auth()->user()->uuid) }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('ratings.my_ratings_go_back') }}</a>
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
                            <p class="font-medium text-base">{{ $patient->user->first_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                            <p class="font-medium text-base">{{ $patient->user->last_name }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.phone") }}</label>
                            <p class="font-medium text-base">{{ $patient->user->phone }}</p>
                        </div>
                        <div class="">
                            <label class="mb-2 text-xs">{{ __("common.email") }}</label>
                            <p class="font-medium text-base">{{ $patient->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="w-full overflow-x-auto">
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
        </div>
        <div class="form-card">
            <h2 class="font-bold text-lg mb-4">{{ __('common.received_rating_title') . ' ' . $patient->user->first_name }}</h2>
            <div class="mb-4">
                <x-specialist-rating :rating="$rating->rating"/>
            </div>
            @if($rating->remarks)
                <div class="mb-4">
                    <p class="mb-2">{{ __('common.comments') }}</p>
                    <p>{{ $rating->remarks }}</p>
                </div>
            @endif
        </div>
        <div class="form-card">
                <h2 class="font-bold text-lg mb-4"
                >{{ __('common.specialist_existing_rating_reply') }}</h2>
            <div class="mb-4">
                {!!  $rating->specialist_reply
                    ? $rating->specialist_reply
                    : '<span class="add-reply span cursor-pointer text-blue-500">' . __('common.specialist_reply_rating_cta') . '</span>' !!}
            </div>
            @if(!$rating->specialist_reply)
            <div class="mb-4 specialist-reply hidden">
                <form method="post" action="{{ route('specialist.ratings.update', ['uuid' => auth()->user()->uuid, 'rating' => $rating->id]) }}">
                    @csrf
                    @method('PUT')
                    <x-textarea class="mb-4" name="specialist_reply" placeholder="{{ __('common.specialist_reply_placeholder') }}"></x-textarea>
                    <div class="mb-4 text-sm text-right">
                        <x-button>{{ __('common.save_changes') }}</x-button>
                    </div>
                </form>
            </div>
            @endif
        </div>

        @if(!$rating->dispute)
            <div>
                <p>Si no estás conforme con esta valoración, haz clic
                    <span class="text-blue-500 underline cursor-pointer"
                          @click="openModal('#requestDispute')">aquí</span>
                    para solicitar una revisión</p>
            </div>
            <livewire:request-rating-dispute :modal="'requestDispute'" :rating="$rating"/>
        @elseif($rating->dispute->state === App\Models\RatingDispute::STATE_RESOLVED)
            <div>Esta valoración tuvo una disputa que ha sido resuelta el {{ $rating->dispute->updatedReadable }}</div>
        @else
            <div>Esta valoración está siendo disputada ahora mismo</div>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
    @push('scripts')
        <script>
            let add_reply = document.querySelector('.add-reply');

            if (add_reply) {
                add_reply.addEventListener('click', function () {
                    document.querySelector('.specialist-reply').classList.toggle('hidden');
                });
            }
        </script>
    @endpush
</x-app-layout>
