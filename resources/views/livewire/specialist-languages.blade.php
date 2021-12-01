<div>
    <div class="form-card">
        <h2 class="font-bold text-xl">{{ __('language.language_block_title') }}</h2>
        <p class="font-normal text-base mb-2">{{ __('language.language_copy') }}</p>
        @if (count($removedLanguagesList) > 0)
            <input type="hidden" name="languageToDelete" value="{{ implode(',', $removedLanguagesList) }}">
        @endif
        <div class="mb-4 sortable">
        @if(!$specialist->profile->languages->isEmpty())
                @foreach($specialist->profile->languages as $language)
                    <div class="mb-4 sortable-children" data-order="certificate[{{ $language->id }}][order]">
                        <div
                            class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                            <div>
                                <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                                <input type="hidden" name="language[{{ $language->id }}][order]" value="{{ $language->order }}">
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('language.language') }}</label>
                                <select name="language[{{ $language->id }}][language]"
                                        class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                                    @foreach(languagesList() as $languageId => $label)
                                        <option value="{{ $languageId }}" {{ $languageId == $language->language ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{--<div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('language.language_institution') }}</label>
                                <x-input name="language[{{ $language->id }}][proficiency]" value="{{ $language->institution }}"></x-input>
                            </div>--}}
                            <div class="flex-1 text-right">
                                <i class="fas fa-times-circle text-red-500 cursor-pointer"
                                   wire:click="$emit('removeLanguage', {{ $language->id }})"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
        @endif
        @if($languagesCounter > 0)
            @for ($i = 0; $i < $languagesCounter; $i++)
                <div class="mb-4 sortable-children" data-order="certificate[{{ $i }}][order]">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                            <input type="hidden" name="language[{{ $i }}][order]" value="{{ $i + 1 }}">
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('language.language') }}</label>
                            <select name="language[{{ $i }}][language]"
                                    class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                                <option value="" selected>--</option>
                                @foreach(languagesList() as $language => $label)
                                    <option value="{{ $language }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('language.language_institution') }}</label>
                            <x-input name="language[{{ $i }}][proficiency]"></x-input>
                        </div>--}}
                        <div class="flex-1 text-right">
                            <i class="fas fa-times-circle text-red-500 cursor-pointer" wire:click="$emit('removeLanguage')"></i>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
        </div>
        @if(auth()->user()->profile->isPremium())
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addLanguage')"><i class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
        @endif
        @if(!auth()->user()->profile->isPremium())
            <x-premium-sponsor-block title="{{ __('language.language_premium_copy_title') }}" subtitle="{{ __('language.language_premium_copy_subtitle') }}"/>
        @endif
    </div>
</div>
