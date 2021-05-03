<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('online-platforms.online_platforms') }}</h2>
            <a class="text-blue-500" href="{{ route('online-platforms.create') }}">{{ __('online-platforms.new_op') }}</a>
        </div>
        <x-results-table :results="$onlinePlatforms"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'online-platforms.edit','delete' => 'online-platforms.destroy', 'sort' => 'online-platforms.sort']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
