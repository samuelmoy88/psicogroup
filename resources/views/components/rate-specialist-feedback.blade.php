<div class="hidden" id="rating-feedback">
    <div class="rating-feedback flex flex-wrap">
        <div class="positive-remarks mb-4 w-full">
            <p class="positive-copy mb-4">{{ __('common.positive_feedback_copy') }}</p>
            <p class="negative-copy mb-4">{{ __('common.negative_feedback_positive_copy') }}</p>
            <div class="flex flex-wrap gap-4 lg:w-1/2">
                @foreach($positiveFeedback as $feedback)
                    <label class="relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between">
                        <input type="checkbox" name="feedback_rating[]" value="{{ $feedback['id'] }}" class="sr-only" aria-labelledby="server-size-0-label" aria-describedby="server-size-0-description-0 server-size-0-description-1">
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
        <div class="negative-remarks mb-4 w-full">
            <p class="positive-copy mb-4">{{ __('common.positive_feedback_negative_copy') }}</p>
            <p class="negative-copy mb-4">{{ __('common.negative_feedback_copy') }}</p>
            <div class="flex flex-wrap gap-4 lg:w-1/2">
                @foreach($negativeFeedback as $feedback)
                    <label class="relative block rounded-lg border border-gray-300 bg-white shadow-sm px-6 py-4 cursor-pointer hover:border-gray-400 sm:flex sm:justify-between">
                        <input type="checkbox" name="feedback_rating[]" value="{{ $feedback['id'] }}" class="sr-only" aria-labelledby="server-size-0-label" aria-describedby="server-size-0-description-0 server-size-0-description-1">
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
