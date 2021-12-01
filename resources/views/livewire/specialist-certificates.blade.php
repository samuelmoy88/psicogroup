<div>
    <div class="form-card certificates">
        <h2 class="font-bold text-xl">{{ __('certificate.certificate_block_title') }}</h2>
        <p class="font-normal text-base mb-2">{{ __('certificate.certificate_copy') }}</p>
        @if (count($removedCertificatesList) > 0)
            <input type="hidden" name="certificateToDelete" value="{{ implode(',', $removedCertificatesList) }}">
        @endif
        <div class="mb-4 sortable">
            @if(!$specialist->profile->certificates->isEmpty())
                @foreach($specialist->profile->certificates as $certificate)
                    <div class="mb-4 sortable-children" data-order="certificate[{{ $certificate->id }}][order]">
                        <div
                            class=" px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                            <div>
                                <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                                <input type="hidden" name="certificate[{{ $certificate->id }}][order]" value="{{ $certificate->order }}">
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_expedition_date') }}
                                    *</label>
                                <x-month-year-picker month="certificate[{{ $certificate->id }}][expedition_month]"
                                                     year="certificate[{{ $certificate->id }}][expedition_year]"
                                                     :selectedMonth="$certificate->expeditionMonthFormatted"
                                                     :selectedYear="$certificate->expeditionYearFormatted"/>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_name') }}</label>
                                <x-input name="certificate[{{ $certificate->id }}][name]"
                                         value="{{ $certificate->name }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_company_name') }}</label>
                                <x-input name="certificate[{{ $certificate->id }}][company_name]"
                                         value="{{ $certificate->company_name }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_location') }}</label>
                                <x-input name="certificate[{{ $certificate->id }}][location]"
                                         value="{{ $certificate->location }}"></x-input>
                            </div>
                            <div>
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_expires') }}</label>
                                <x-checkbox checked="{{ $certificate->expires ? true : false }}"
                                            name="certificate[{{ $certificate->id }}][expires]" value="1"
                                            class="toggle_expiration"/> {{ __('common.yes') }}
                            </div>
                            <div class="expiration_date {{ !$certificate->expires ? 'hidden' : '' }}">
                                <label
                                    class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_expiration_date') }}</label>
                                <x-month-year-picker operation="add"
                                                     month="certificate[{{ $certificate->id }}][expiration_month]"
                                                     year="certificate[{{ $certificate->id }}][expiration_year]"
                                                     :selectedMonth="$certificate->expirationMonthFormatted"
                                                     :selectedYear="$certificate->expirationYearFormatted"/>
                            </div>
                            <div>
                                <i class="fas fa-times-circle text-red-500 cursor-pointer"
                                   wire:click="$emit('removeCertificate', {{ $certificate->id }})"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
        @endif
        @if($certificatesCounter)
            @for ($i = 0; $i < $certificatesCounter; $i++)
                <div class="mb-4 sortable-children" data-order="certificate[{{ $i }}][order]">
                    <div
                        class="px-3 py-5 bg-gray-50 text-black rounded-md flex flex-col items-center space-x-0 space-y-5 sm:space-x-5 sm:space-y-0 sm:flex-row justify-between">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                            <input type="hidden" name="certificate[{{ $i }}][order]" value="{{ $i + 1 }}">
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_expedition_date') }}
                                *</label>
                            <x-month-year-picker month="certificate[{{ $i }}][expedition_month]"
                                                 year="certificate[{{ $i }}][expedition_year]"/>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_name') }}</label>
                            <x-input name="certificate[{{ $i }}][name]"></x-input>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_company_name') }}</label>
                            <x-input name="certificate[{{ $i }}][company_name]"></x-input>
                        </div>
                        <div class="">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_location') }}</label>
                            <x-input name="certificate[{{ $i }}][location]"></x-input>
                        </div>
                        <div class="expires">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_expires') }}</label>
                            <x-checkbox name="certificate[{{ $i }}][expires]" value="1"
                                        class="toggle_expiration"/> {{ __('common.yes') }}
                        </div>
                        <div class="expiration_date hidden">
                            <label
                                class="flex items-center mb-1 cursor-pointer">{{ __('certificate.certificate_expiration_date') }}</label>
                            <x-month-year-picker operation="add" month="certificate[{{ $i }}][expiration_month]"
                                                 year="certificate[{{ $i }}][expiration_year]"/>
                        </div>
                        <div>
                            <i class="fas fa-times-circle text-red-500 cursor-pointer"
                               wire:click="$emit('removeCertificate')"></i>
                        </div>
                    </div>
                </div>
            @endfor
        @endif
        </div>
        @if(auth()->user()->profile->isPremium())
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addCertificate')"><i
                    class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
        @endif
        @if(!auth()->user()->profile->isPremium())
            <x-premium-sponsor-block title="{{ __('certificate.certificate_premium_copy_title') }}"
                                     subtitle="{{ __('certificate.certificate_premium_copy_subtitle') }}"/>
        @endif
    </div>
    <script>
        window.addEventListener('checkIfExpirationIsChecked', () => {
            let expireCheckboxes = document.querySelectorAll('.toggle_expiration');
            if (expireCheckboxes) {
                for (let i of expireCheckboxes) {
                    if (i.checked) {
                        i.parentElement.nextElementSibling.classList.remove('hidden');
                    }
                }
            }
        });
        document.querySelector('.certificates').addEventListener('click', (e) => {
            if (e.target && e.target.classList.contains('toggle_expiration')) {
                if (e.target.checked) {
                    e.target.parentElement.nextElementSibling.classList.remove('hidden');
                } else {
                    e.target.parentElement.nextElementSibling.classList.add('hidden');
                }

            }
        });
    </script>
</div>
