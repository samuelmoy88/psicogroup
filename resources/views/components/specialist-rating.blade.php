@props(['rating' => null, 'inputs' => false])

<div class="flex space-x-2">
    @foreach((new \App\Models\Rating)->ratings as $_rating)
        <div class="flex items-center">
            @if($inputs)
            <input name="rating" type="radio" {{ $rating->rating == $_rating ? 'checked' : '' }}
            value="{{ $_rating }}"
                   class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
            @endif
            <i class="filled fas fa-star {{ $rating >= $_rating ? 'text-brand-color' : 'hidden-important' }}"></i> {{--<-rellena--}}
            <i class="empty far fa-star {{ $rating >= $_rating ? 'hidden-important' : 'text-brand-color' }}"></i>
        </div>
    @endforeach
    <p>{{ __('ratings.'.$rating.'_rating_copy') }}</p>
</div>
