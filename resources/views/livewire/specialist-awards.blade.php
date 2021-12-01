<div>
    <div class="form-card">
        <h2 class="font-bold text-xl">{{ __('award.award_block_title') }}</h2>
        <p class="font-normal text-base mb-2">{{ __('award.award_copy') }}</p>
        @if (count($removedAwardsList) > 0)
            <input type="hidden" name="awardsToDelete" value="{{ implode(',', $removedAwardsList) }}">
        @endif
        <div class="mb-4 sortable">
        @if(!$specialist->profile->awards->isEmpty())
            @foreach($specialist->profile->awards as $award)
                <div class="mb-4 sortable-children" data-order="award[{{ $award->id }}][order]">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                            <input type="hidden" name="award[{{ $award->id }}][order]" value="{{ $award->order }}">
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('award.award_year') }}</label>
                            <x-input name="award[{{ $award->id }}][year]" value="{{ $award->year }}"></x-input>
                        </div>
                        <div class="flex-1">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('award.award_title') }}</label>
                            <x-input name="award[{{ $award->id }}][title]" value="{{ $award->title }}"></x-input>
                        </div>
                        <div>
                            <i class="fas fa-times-circle text-red-500 cursor-pointer"
                               wire:click="$emit('removeAward', {{ $award->id }})"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if($awardsCounter > 0)
            @for ($i = 0; $i < $awardsCounter; $i++)
                <div class="mb-4 sortable-children" data-order="award[{{ $i }}][order]">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                            <input type="hidden" name="award[{{ $i }}][order]" value="{{ $i }}">
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('award.award_year') }}</label>
                            <x-input name="award[{{ $i }}][year]"></x-input>
                        </div>
                        <div class="flex-1">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('award.award_title') }}</label>
                            <x-input name="award[{{ $i }}][title]"></x-input>
                        </div>
                        <div>
                            <i class="fas fa-times-circle text-red-500 cursor-pointer" wire:click="$emit('removeAward')"></i>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
        </div>
        @if(auth()->user()->profile->isPremium())
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addAward')"><i class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
        @endif
        @if(!auth()->user()->profile->isPremium())
            <x-premium-sponsor-block title="{{ __('award.award_premium_copy_title') }}" subtitle="{{ __('award.award_premium_copy_subtitle') }}"/>
        @endif
    </div>
</div>
