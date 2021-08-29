@props(['rating' => null, 'inputs' => false])
<div id="rating">
    <p class="mb-2">{{ __('common.rating_copy') }}</p>
    <div class="flex space-x-2 h-5" id="ratings">
        <div class="hidden" id="currentRating" data-current-rating="{{ $rating }}"></div>
        <input type="hidden" name="rating" value="{{ $rating ? $rating : 0 }}">
        @foreach((new \App\Models\Rating)->ratings as $_rating)
            <div class="flex items-center">
                <i data-rating="{{ $_rating }}"
                   class="filled fas fa-star cursor-pointer mr-2 text-brand-color {{ $rating >= $_rating ? '' : 'hidden-important' }}"></i> {{--<-rellena--}}
                <i data-rating="{{ $_rating }}"
                   class="empty far fa-star cursor-pointer mr-2 text-brand-color {{ $rating >= $_rating ? 'hidden-important' : '' }}"></i>
            </div>
        @endforeach
        <div class="">
            @foreach((new \App\Models\Rating)->ratings as $_rating)
                <p data-rating="{{ $_rating }}"
                   class="rating-copy {{ $rating !== $_rating ? 'hidden-important' : '' }}"
                >{{ __('ratings.'.$_rating.'_rating_copy') }}</p>
            @endforeach
        </div>
    </div>
</div>
