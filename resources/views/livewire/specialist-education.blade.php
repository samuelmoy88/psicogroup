<div>
    <div class="form-card">
        <h2 class="font-bold text-xl">{{ __('education.education_block_title') }}</h2>
        <p class="font-normal text-base mb-2">{{ __('education.education_copy') }}</p>
        <p class="font-normal text-base mb-2">{{ __('publication.publication_copy') }}</p>
        @if (count($removedEducationList) > 0)
            <input type="hidden" name="educationToDelete" value="{{ implode(',', $removedEducationList) }}">
        @endif
        <div class="mb-4 sortable">
        @if(!$specialist->profile->education->isEmpty())
            @foreach($specialist->profile->education as $education)
                <div class="mb-4 sortable-children" data-order="education[{{ $education->id }}][order]">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                            <input type="hidden" name="education[{{ $education->id }}][order]" value="{{ $education->order }}">
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('education.education_level') }}</label>
                            <select name="education[{{ $education->id }}][level]"
                                    class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                                @foreach($educationLevels as $level)
                                    <option value="{{ $level->id }}" {{ $level->id == $education->level ? 'selected' : '' }}>{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('education.education_institution') }}</label>
                            <x-input name="education[{{ $education->id }}][institution]" value="{{ $education->institution }}"></x-input>
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('education.education_title') }}</label>
                            <x-input name="education[{{ $education->id }}][title]" value="{{ $education->title }}"></x-input>
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('education.education_end_date') }}</label>
                            <x-input name="education[{{ $education->id }}][end]" value="{{ $education->end }}"></x-input>
                        </div>
                        <div>
                            <i class="fas fa-times-circle text-red-500 cursor-pointer"
                               wire:click="$emit('removeEducation', {{ $education->id }})"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if($educationCounter)
            @for ($i = 0; $i < $educationCounter; $i++)
            <div class="mb-4 sortable-children" data-order="education[{{ $i }}][order]">
                <div
                    class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                    <div>
                        <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                        <input type="hidden" name="education[{{ $i }}][order]" value="{{ $i + 1 }}">
                    </div>
                    <div>
                        <label
                            class="flex items-center mb-1 cursor-pointer">{{ __('education.education_level') }}</label>
                        <select name="education[{{ $i }}][level]"
                                class="border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                            @foreach($educationLevels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label
                            class="flex items-center mb-1 cursor-pointer">{{ __('education.education_institution') }}</label>
                        <x-input name="education[{{ $i }}][institution]"></x-input>
                    </div>
                    <div>
                        <label
                            class="flex items-center mb-1 cursor-pointer">{{ __('education.education_title') }}</label>
                        <x-input name="education[{{ $i }}][title]"></x-input>
                    </div>
                    <div>
                        <label
                            class="flex items-center mb-1 cursor-pointer">{{ __('education.education_end_date') }}</label>
                        <x-input name="education[{{ $i }}][end]"></x-input>
                    </div>
                    <div>
                        <i class="fas fa-times-circle text-red-500 cursor-pointer" wire:click="$emit('removeEducation')"></i>
                    </div>
                </div>
            </div>
            @endfor
        @endif
        </div>
        @if(auth()->user()->profile->isPremium())
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addEducation')"><i class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
        @endif
        @if(!auth()->user()->profile->isPremium())
            <x-premium-sponsor-block title="{{ __('education.education_premium_copy_title') }}" subtitle="{{ __('education.education_premium_copy_subtitle') }}"/>
        @endif
    </div>
</div>
