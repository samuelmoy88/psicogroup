<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('specialities.specialities') }}</h2>
            <a class="text-blue-500" href="{{ route('specialities.create') }}">{{ __('specialities.new_speciality') }}</a>
        </div>
        <x-results-table :results="$specialities"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'specialities.edit','delete' => 'specialities.destroy']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
