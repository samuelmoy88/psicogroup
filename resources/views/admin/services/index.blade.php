<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('services.services') }}</h2>
            <a class="text-blue-500" href="{{ route('services.create') }}">{{ __('services.new_service') }}</a>
        </div>
        <x-results-table :results="$services"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'services.edit','delete' => 'services.destroy', 'sort' => true]"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
