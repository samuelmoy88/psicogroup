<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('payment-methods.payment_methods') }}</h2>
            <a class="text-blue-500" href="{{ route('payment-methods.create') }}">{{ __('payment-methods.new_pm') }}</a>
        </div>
        <x-results-table :results="$paymentMethods"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'payment-methods.edit','delete' => 'payment-methods.destroy', 'sort' => 'payment-methods.sort']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
