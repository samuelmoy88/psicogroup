<div>
    @forelse($services as $service)
        <div class="p-4 mb-4 text-sm w-full flex flex-wrap space-x-4 flex-col md:flex-row bg-gray-100" wire:key="{{ $loop->index }}">
            <div>
                <i class="fas fa-sort cursor-pointer handle"></i>
            </div>
            <div class="flex-1 space-y-2">
                @if(!$loop->last)
                <x-input type="text" value="{{ $service['label'] }}" name="customServices[{{ $loop->index }}][label]" placeholder="{{ __('Enter the name of your service') }}"/>
                @else
                <x-input type="text" wire:model.lazy="label" value="{{ $service['label'] }}" name="customServices[{{ $loop->index }}][label]" placeholder="{{ __('Enter the name of your service') }}"/>
                @endif
                <x-textarea rows="2" placeholder="{{ __('Add details about the service so patients want to choose you when looking for a specialist ') }}" name="customServices[{{ $loop->index }}][description]"></x-textarea>
            </div>
            <div class="flex flex-wrap space-x-4 items-start">
                <label class="flex items-center mb-2 cursor-pointer">
                    <x-checkbox name="customServices[{{ $loop->index }}][price_from]" value="1"/>
                    <span class="ml-2">{{ __('From') }}</span>
                </label>
                <div class="relative text-gray-500">
                    <x-input type="number" value="" id="" name="customServices[{{ $loop->index }}][price]"/>
                    <button class="absolute inset-y-0 right-0 rounded-r-md inline-flex items-center px-4 py-2 bg-brand-color border border-transparent font-medium text-white tracking-widest active:bg-purple-800 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple disabled:opacity-25 transition ease-in-out duration-150">S/</button>
                </div>
            </div>
            @if($addresses)
                <div class="mt-2 flex flex-wrap w-full space-x-4">
                    <p class="w-full text-bold text-black mb-4">{{ __('Consultations for this service') }}</p>
                    @foreach($addresses as $address)
                        <label class="flex items-center mb-2 cursor-pointer">
                            <x-checkbox name="customServices[{{ $loop->index }}][addresses][]" value="{{ $address->id }}"/>
                            <span class="ml-2">{{ $address->title }}</span>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>
        @empty
    @endforelse
    <div class="mb-4 text-sm">
        <x-button wire:click="$emit('serviceLoaded')" type="button"><i class="fas fa-plus mr-2"></i>{{ __('Add new service') }}</x-button>
    </div>
</div>
