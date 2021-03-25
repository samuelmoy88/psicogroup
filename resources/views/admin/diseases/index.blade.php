<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('diseases.diseases') }}</h2>
            <a class="text-blue-500" href="{{ route('diseases.create') }}">{{ __('diseases.new_disease') }}</a>
        </div>
        <x-results-table :results="$diseases"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'diseases.edit','delete' => 'diseases.destroy']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
