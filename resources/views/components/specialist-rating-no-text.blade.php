@props(['rating' => null])

<div class="flex space-x-2">
    @foreach((new \App\Models\Rating)->ratings as $_rating)
        <div class="flex items-center">
            <i class="filled fas fa-star {{ $rating >= $_rating ? 'text-brand-color' : 'hidden-important' }}"></i> {{--<-rellena--}}
            <i class="empty far fa-star {{ $rating >= $_rating ? 'hidden-important' : 'text-brand-color' }}"></i>
        </div>
    @endforeach
</div>
