<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('uneasiness.uneasiness') }}</h2>
            <a class="text-blue-500" href="{{ route('uneasiness.create') }}">{{ __('uneasiness.new_unease') }}</a>
        </div>
        <x-results-table :results="$uneasiness"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'uneasiness.edit','delete' => 'uneasiness.destroy', 'sort' => 'uneasiness.sort']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
