<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('config.roles') }}</h2>
            <a class="text-blue-500" href="{{ route('config.roles.create') }}">{{ __('config.new_role') }}</a>
        </div>
        <x-results-table :results="$roles"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'config.roles.edit', 'delete' => 'config.roles.destroy']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
