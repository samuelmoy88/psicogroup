<div>
    <div class="">
        @if (count($removedFeaturesList) > 0)
            <input type="hidden" name="featureToDelete" value="{{ implode(',', $removedFeaturesList) }}">
        @endif
        <div class="sortable">
            @if(!$premiumPlan->features->isEmpty())
                    @foreach($premiumPlan->features as $feature)
                        <div class="mb-4 sortable-children" data-order="feature[{{ $feature->id }}][order]">
                            <div
                                class="px-3 py-5 bg-gray-50 text-black rounded-md grid grid-cols-12 gap-2">
                                <div class="col-span-1">
                                    <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                                    <input type="hidden" name="feature[{{ $feature->id }}][order]" value="{{ $feature->order }}">
                                </div>
                                <div class="flex flex-wrap justify-between col-span-11">
                                    <div class="mb-4 w-full sm:w-1/2">
                                        <label
                                            class="flex items-center mb-1 cursor-pointer">{{ __('common.title') }}</label>
                                        <x-input name="feature[{{ $feature->id }}][title]" value="{{ $feature->title }}"></x-input>
                                    </div>
                                    <div class="mb-4 w-full sm:w-1/2 sm:text-right">
                                        <input type="hidden" name="feature[{{ $feature->id }}][status]" value="0">
                                        <label for="feature[{{ $feature->id }}][status]"
                                            class="mb-1 cursor-pointer">{{ __('common.feature_is_active') }}</label><br>
                                        <x-checkbox checked="{{ $feature->current_job ? true : false }}"
                                                    id="feature[{{ $feature->id }}][status]"
                                                    name="feature[{{ $feature->id }}][status]" value="1"/>
                                    </div>
                                    <div class="w-full">
                                        <label
                                            class="flex items-center mb-1 cursor-pointer">{{ __('common.description') }}</label>
                                        <x-textarea
                                            name="feature[{{ $feature->id }}][description]" class="rich-editor">{!! $feature->description !!}</x-textarea>
                                    </div>
                                    <div>
                                        <p class="text-red-500 cursor-pointer mt-2"
                                           wire:click="$emit('removeFeature', {{ $feature->id }})">
                                            {{ __('common.delete') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
            @endif
            @if($featuresCounter)
                    @for ($i = 0; $i < $featuresCounter; $i++)
                        <div class="mb-4 sortable-children" data-order="feature[{{ $i }}][order]">
                            <div
                                class="px-3 py-5 bg-gray-50 text-black rounded-md grid grid-cols-12 gap-2">
                                <div class="col-span-1">
                                    <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
                                    <input type="hidden" name="new_feature[{{ $i }}][order]" value="{{ $i }}">
                                </div>
                                <div class="flex flex-wrap justify-between col-span-11">
                                    <div class="mb-4 w-full sm:w-1/2">
                                        <label
                                            class="flex items-center mb-1 cursor-pointer">{{ __('common.title') }}</label>
                                        <x-input name="new_feature[{{ $i }}][title]"></x-input>
                                    </div>
                                    <div class="mb-4 w-full sm:w-1/2 sm:text-right">
                                        <input type="hidden" name="new_feature[{{ $i }}][status]" value="0">
                                        <label for="new_feature[{{ $i }}][status]"
                                            class="mb-1 cursor-pointer">{{ __('common.feature_is_active') }}</label><br>
                                        <x-checkbox id="new_feature[{{ $i }}][status]"
                                            name="new_feature[{{ $i }}][status]" value="1"/>
                                    </div>
                                    <div class="w-full">
                                        <label
                                            class="flex items-center mb-1 cursor-pointer">{{ __('common.description') }}</label>
                                        <x-textarea name="new_feature[{{ $i }}][description]" class="new-editors"></x-textarea>
                                    </div>
                                    <div>
                                        <p class="text-red-500 cursor-pointer mt-2"
                                           wire:click="$emit('removeFeature')">
                                            {{ __('common.delete') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
            @endif
        </div>
        <div>
            <button type="button" class="cursor-pointer" wire:click="$emit('addFeature')"><i class="fas fa-plus"></i> {{ __('common.add') }}</button>
        </div>
    </div>
    <script>
        window.addEventListener('loadCkeditor', function () {
            let ckeditorElements = document.querySelectorAll('.new-editors');

            if (ckeditorElements.length > 0) {
                for (let e of ckeditorElements) {
                    let name = e.getAttribute('name');
                    let data = '';
                    if (CKEDITOR.instances.hasOwnProperty(name)) {
                        data = CKEDITOR.instances[name].getData();
                        CKEDITOR.instances[name].destroy(true);
                    }
                    CKEDITOR.replace(e);
                    CKEDITOR.instances[name].setData(data);
                }
            }
            let ckeditorInlineElements = document.querySelectorAll('.rich-editor');

            if (ckeditorInlineElements.length > 0) {
                for (let e of ckeditorInlineElements) {
                    let name = e.getAttribute('name');
                    let data = '';
                    if (CKEDITOR.instances.hasOwnProperty(name)) {
                        data = CKEDITOR.instances[name].getData();
                        CKEDITOR.instances[name].destroy(true);
                    }
                    CKEDITOR.replace(e);
                    CKEDITOR.instances[name].setData(data);
                }
            }
        });
    </script>
</div>
