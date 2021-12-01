<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('social-media.name') }}</h2>
            <a class="text-blue-500" href="{{ route('social-media.create') }}">{{ __('social-media.new_sm') }}</a>
        </div>
        <x-results-table :results="$social_media"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'social-media.edit','delete' => 'social-media.destroy', 'sort' => 'social-media.sort']"/>
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
