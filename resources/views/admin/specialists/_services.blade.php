<div class="form-card">
    <div class="flex flex-wrap justify-between">
        <h2 class="font-bold text-lg mb-4">{{ __('common.services') }}</h2>
        @foreach($specialist->profile->services as $service)
            <div class="w-full">
                <ul class="list-disc pl-5">
                    <li>{{ $service->title }}</li>
                </ul>
                <div class="pl-2 grid sm:grid-cols-3 gap-3">
                    @if($service->pivot->description)
                        <div>
                            <label class="mb-2 text-xs">{{ __('common.description') }}</label>
                            <p class="font-medium text-base">{{ $service->pivot->description }}</p>
                        </div>
                    @endif
                    @if($service->pivot->price)
                        <div>
                            <label class="mb-2 text-xs">{{ __('common.price') }}</label>
                            <p class="font-medium text-base">{{ $service->pivot->price }}
                                {{ $service->pivot->price_from ? ' ('.__('common.from').')' : '' }}</p>
                        </div>
                    @endif
                </div>
                @if(!$loop->last)
                    <hr class="my-5"> @endif
            </div>
        @endforeach
    </div>
</div>
