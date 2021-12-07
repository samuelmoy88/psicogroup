<x-admin-layout>
    <div class="form-card">
        <div class="flex flex-wrap justify-between">
            <h2 class="font-bold text-xl mb-4">
                {{ __('premium-plans.edit_pp') }}
            </h2>
            <a href="{{ route('premium-plan.index') }}" class="text-blue-500">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('premium-plans.go_back') }}
            </a>
        </div>
        <form class="grid grid-cols-2 gap-4" action="{{ route('premium-plan.update', $premiumPlan->id) }}" method="post">
            @method('PUT')
            @csrf
            <div class="mb-4 text-sm col-span-2 sm:col-span-1">
                <x-label for="title">{{ __("common.title") }} *</x-label>
                <x-input required type="text" value="{{ $premiumPlan->title }}" id="title" name="title"/>
            </div>
            <div class="mb-4 text-sm col-span-2 sm:col-span-1">
                <x-label for="title">{{ __("common.status") }} *</x-label>
                <select name="status" id="status"
                        class="mb-4 border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                    @foreach($premiumPlan->getStates() as $state => $label)
                        <option {{ $state == $premiumPlan->status ? 'selected' : ( $state == \App\Models\PremiumPlan::STATE_ACTIVE ? 'selected' : '') }}
                            value="{{ $state }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4 text-sm col-span-2">
                <x-label for="description">{{ __("common.description") }} *</x-label>
                <textarea required id="description" name="description" class="rich-editor"
                >{{ $premiumPlan->description }}</textarea>
            </div>
            <div class="mb-4 text-sm col-span-2 sm:col-span-1">
                <x-label for="price">{{ __("common.price") }} *</x-label>
                <x-input required min="0" step="any" type="number" value="{{ $premiumPlan->price }}" id="price" name="price"/>
            </div>
            <div class="mb-4 text-sm col-span-2 sm:col-span-1">
                <x-label class="mb-2" for="price">{{ __("common.payment_frequency_plan") }} *</x-label>
                <fieldset>
                    <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                        @foreach($paymentFrequencies as $frequency)
                            <div class="flex items-center">
                                <x-checkbox checked="{{ !$premiumPlan->paymentFrequencies->isEmpty() && $premiumPlan->paymentFrequencies->contains('id', $frequency->id) ? true : false }}"
                                    name="paymentFrequency[]" id="{{ $loop->index }}" value="{{ $frequency->id }}" class="h-4 w-4"/>
                                <label for="{{ $loop->index }}" class="ml-3 cursor-pointer block text-sm font-medium text-gray-700">
                                    {{ $frequency->label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            </div>
            <div class="mb-4 text-sm col-span-2 sm:col-span-1">
                <x-label for="discount">{{ __("common.discount") }}</x-label>
                <x-input type="number" step="any" value="{{ $premiumPlan->discount ?: 0}}" id="discount" name="discount"/>
            </div>
            <div class="mb-4 text-sm col-span-2 sm:col-span-1">
                <x-label for="discount_until">{{ __("common.discount_until") }}</x-label>
                <x-input type="datetime-local" value="{{ $premiumPlan->discount_until ? $premiumPlan->discountUntilInputFormat : '' }}" id="discount_until" name="discount_until"/>
            </div>
            <div class="mb-4 text-sm col-span-2">
                <h2 class="font-bold text-lg mb-4">
                    {{ __('common.features') }}
                </h2>
                <div>
                    <livewire:premium-plan-features :premiumPlan="$premiumPlan"/>
                </div>
            </div>
            <div class="mb-4 text-sm text-right col-span-2">
                <x-button>Guardar cambios</x-button>
            </div>
        </form>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
    @if(session('error'))
        <x-toast-error-alert id="errorMessage">
            {{ session('error') }}
        </x-toast-error-alert>
    @endif
</x-admin-layout>
