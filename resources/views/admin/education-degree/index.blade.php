<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('education-degree.name') }}</h2>
            <a class="text-blue-500" href="{{ route('education-degree.create') }}">{{ __('education-degree.new_ed') }}</a>
        </div>
        <x-results-table :results="$education_degree"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'education-degree.edit','delete' => 'education-degree.destroy', 'sort' => 'education-degree.sort']"/>
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
