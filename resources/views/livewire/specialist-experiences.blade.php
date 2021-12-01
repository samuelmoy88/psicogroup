<div>
    <div class="form-card">
        <h2 class="font-bold text-xl">{{ __('experience.experience_block_title') }}</h2>
        <p class="font-normal text-base mb-2">{{ __('experience.experience_copy') }}</p>
        @if (count($removedExperiencesList) > 0)
            <input type="hidden" name="experienceToDelete" value="{{ implode(',', $removedExperiencesList) }}">
        @endif
        @if(!$specialist->profile->experiences->isEmpty())
            <div class="mb-4">
                @foreach($specialist->profile->experiences as $award)
                    <div class="mb-4">
                        <div
                            class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_start_year') }} *</label>
                                <x-month-year-picker month="experience[{{ $award->id }}][start_month]" year="experience[{{ $award->id }}][start_year]" :selectedMonth="$award->startMonthFormatted" :selectedYear="$award->startYearFormatted"/>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_end_year') }}</label>
                                <x-month-year-picker month="experience[{{ $award->id }}][end_month]" year="experience[{{ $award->id }}][end_year]" :selectedMonth="$award->endMonthFormatted" :selectedYear="$award->endYearFormatted"/>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_job_title') }}</label>
                                <x-input name="experience[{{ $award->id }}][job_title]" value="{{ $award->job_title }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_company_name') }}</label>
                                <x-input name="experience[{{ $award->id }}][company_name]" value="{{ $award->company_name }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_location') }}</label>
                                <x-input name="experience[{{ $award->id }}][location]" value="{{ $award->location }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_current_job') }}</label>
                                <x-checkbox checked="{{ $award->current_job ? true : false }}"
                                    name="experience[{{ $award->id }}][current_job]" value="1"/>
                            </div>
                            <div>
                                <i class="fas fa-times-circle text-red-500 cursor-pointer"
                                   wire:click="$emit('removeExperience', {{ $award->id }})"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if($experiencesCounter)
        <div class="mb-4">
            @for ($i = 0; $i < $experiencesCounter; $i++)
                <div class="mb-4">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_start_year') }} *</label>
                            <x-month-year-picker month="experience[{{ $i }}][start_month]" year="experience[{{ $i }}][start_year]"/>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_end_year') }}</label>
                            <x-month-year-picker month="experience[{{ $i }}][end_month]" year="experience[{{ $i }}][end_year]"/>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_job_title') }}</label>
                            <x-input name="experience[{{ $i }}][job_title]"></x-input>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_company_name') }}</label>
                            <x-input name="experience[{{ $i }}][company_name]"></x-input>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_location') }}</label>
                            <x-input name="experience[{{ $i }}][location]"></x-input>
                        </div>
                        <div>
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('experience.experience_current_job') }}</label>
                            <x-checkbox name="experience[{{ $i }}][current_job]" value="1"/>
                        </div>
                        <div>
                            <i class="fas fa-times-circle text-red-500 cursor-pointer" wire:click="$emit('removeExperience')"></i>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
        @endif
        @if(auth()->user()->profile->isPremium())
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addExperience')"><i class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
        @endif
        @if(!auth()->user()->profile->isPremium())
            <x-premium-sponsor-block title="{{ __('experience.experience_premium_copy_title') }}" subtitle="{{ __('experience.experience_premium_copy_subtitle') }}"/>
        @endif
    </div>
</div>
