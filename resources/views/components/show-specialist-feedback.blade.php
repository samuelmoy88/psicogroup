<div class="">
    <div class="rating-feedback flex flex-wrap">
        <div class="positive-remarks mb-4 w-full">
            <p class="positive-copy mb-4 font-bold">{{ __('common.positive_given_feedback_copy') }}</p>
            <div class="flex flex-wrap gap-4 lg:w-1/2">
                @foreach($positiveFeedback as $feedback)
                    <label class="relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between">
                        <div class="flex items-center
                        {{ $ratingFeedback->contains('id', $feedback['id']) ? 'text-brand-color font-bold' : '' }}">
                            <div class="text-sm">
                                <p id="server-size-0-label" class="font-medium">
                                    {{ $feedback['title'] }}
                                </p>
                            </div>
                        </div>
                        <!-- Checked: "border-indigo-500", Not Checked: "border-transparent" -->
                        <div class="{{ $ratingFeedback->contains('id', $feedback['id']) ? 'bg-brand-color-alpha' : 'border-transparent' }}
                         absolute -inset-px rounded-lg border-2 pointer-events-none border-brand-color" aria-hidden="true"></div>
                    </label>
                @endforeach
            </div>
        </div>
        <div class="negative-remarks mb-4 w-full">
            <p class="positive-copy mb-4 font-bold">{{ __('common.negative_given_feedback_copy') }}</p>
            <div class="flex flex-wrap gap-4 lg:w-1/2">
                @foreach($negativeFeedback as $feedback)
                    <label class="relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between">
                        <div class="flex items-center">
                            <div class="text-sm">
                                <p id="server-size-0-label" class="font-medium">
                                    {{ $feedback['title'] }}
                                </p>
                            </div>
                        </div>
                        <div class="border-transparent absolute -inset-px rounded-lg border-2 pointer-events-none border-brand-color" aria-hidden="true"></div>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>
