<div class="form-card">
    <div class="flex flex-wrap justify-between">
        <h2 class="font-bold text-lg mb-4">{{ __('common.addresses') }}</h2>
        @foreach($specialist->addresses as $address)
            <div class="w-full">
                <ul class="list-disc pl-5">
                    <li>{{ $address->title }}</li>
                </ul>
                <div class="pl-2 grid sm:grid-cols-3 gap-3">
                    <div>
                        <label class="mb-2 text-xs">{{ __('common.practice_type') }}</label>
                        <p class="font-medium text-base">{{ $address->practiceLabel }}</p>
                    </div>
                    <div>
                        <label class="mb-2 text-xs">{{ __('common.consulting_room_name') }}</label>
                        <p class="font-medium text-base">{{ $address->title }}</p>
                    </div>
                    <div>
                        <label class="mb-2 text-xs">{{ __('common.street') }}</label>
                        <p class="font-medium text-base">{{ $address->street }}</p>
                    </div>
                    <div>
                        <label class="mb-2 text-xs">{{ __('common.city') }}</label>
                        <p class="font-medium text-base">{{ $address->city }}</p>
                    </div>
                    <div>
                        <label class="mb-2 text-xs">{{ __('common.zip') }}</label>
                        <p class="font-medium text-base">{{ $address->zip_code }}</p>
                    </div>
                    @if($address->web_site)
                        <div>
                            <label class="mb-2 text-xs">{{ __('common.website') }}</label>
                            <p class="font-medium text-base">{{ $address->web_site }}</p>
                        </div>
                    @endif
                    @if($address->main_phone)
                        <div>
                            <label class="mb-2 text-xs">{{ __('common.main_phone') }}</label>
                            <p class="font-medium text-base">{{ $address->main_phone }}</p>
                        </div>
                    @endif
                    @if($address->secondary_phone)
                        <div>
                            <label class="mb-2 text-xs">{{ __('common.secondary_phone') }}</label>
                            <p class="font-medium text-base">{{ $address->secondary_phone }}</p>
                        </div>
                    @endif
                    @if($address->address_indications)
                        <div>
                            <label class="mb-2 text-xs">
                                {{ $address->consultation_type == 'physical' ?
                                            __('common.how_to_arrive') : __('common.how_to_connect') }}</label>
                            <p class="font-medium text-base">{{ $address->address_indications }}</p>
                        </div>
                    @endif
                </div>
                @if(!$loop->last)
                    <hr class="my-5"> @endif
            </div>
        @endforeach
    </div>
</div>
