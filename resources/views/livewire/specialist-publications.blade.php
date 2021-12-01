<div>
    <div class="form-card">
        <h2 class="font-bold text-xl">{{ __('publication.publication_block_title') }}</h2>
        <p class="font-normal text-base mb-2">{{ __('publication.publication_copy') }}</p>
        @if (count($removedPublicationsList) > 0)
        <input type="hidden" name="publicationsToDelete" value="{{ implode(',', $removedPublicationsList) }}">
        @endif
        @if(!$specialist->profile->publication->isEmpty())
            <div class="mb-4">
                @foreach($specialist->profile->publication as $publication)
                    <div class="mb-4 sortable-children" data-order="publication[{{ $publication->id }}][order]">
                        <div
                            class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                            <div>
                                <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                                <input type="hidden" name="publication[{{ $publication->id }}][order]" value="{{ $publication->order }}">
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('publication.publication_year') }}</label>
                                <x-input name="publication[{{ $publication->id }}][year]" value="{{ $publication->year }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('publication.publication_title') }}</label>
                                <x-input name="publication[{{ $publication->id }}][title]" value="{{ $publication->title }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('publication.publication_url') }}</label>
                                <x-input name="publication[{{ $publication->id }}][url]" value="{{ $publication->url }}"></x-input>
                            </div>
                            <div>
                                <i class="fas fa-times-circle text-red-500 cursor-pointer"
                                   wire:click="$emit('removePublication', {{ $publication->id }})"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if($publicationCounter)
        <div class="mb-4">
            @for ($i = 0; $i < $publicationCounter; $i++)
                <div class="mb-4 sortable-children" data-order="publication[{{ $i }}][order]">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                            <input type="hidden" name="publication[{{ $i }}][order]" value="{{ $i }}">
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('publication.publication_year') }}</label>
                            <x-input name="publication[{{ $i }}][year]"></x-input>
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('publication.publication_title') }}</label>
                            <x-input name="publication[{{ $i }}][title]"></x-input>
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('publication.publication_url') }}</label>
                            <x-input name="publication[{{ $i }}][url]"></x-input>
                        </div>
                        <div>
                            <i class="fas fa-times-circle text-red-500 cursor-pointer" wire:click="$emit('removePublication')"></i>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        @endif
        @if(auth()->user()->profile->isPremium())
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addPublication')"><i class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
        @endif
        @if(!auth()->user()->profile->isPremium())
            <x-premium-sponsor-block title="{{ __('publication.publication_premium_copy_title') }}" subtitle="{{ __('publication.publication_premium_copy_subtitle') }}"/>
        @endif
    </div>
</div>
