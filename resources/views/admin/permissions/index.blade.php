<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('config.permissions') }}</h2>
            <a class="text-blue-500" href="{{ route('config.permissions.create') }}">{{ __('config.new_permissions') }}</a>
        </div>
        <x-results-table :results="$permissions"
                         :resultsAttributes="$attributes"
                         :headers="$headers"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
