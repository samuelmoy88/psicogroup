<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('premium-plans.name') }}</h2>
            <a class="text-blue-500" href="{{ route('premium-plan.create') }}">{{ __('premium-plans.new_pp') }}</a>
        </div>
        <x-results-table :results="$premiumPlans"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'premium-plan.edit','delete' => 'premium-plan.destroy', 'sort' => 'premium-plan.sort']"/>
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
