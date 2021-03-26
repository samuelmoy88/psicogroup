<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('security-measures.security_measures') }}</h2>
            <a class="text-blue-500" href="{{ route('security-measures.create') }}">{{ __('security-measures.new_sm') }}</a>
        </div>
        <x-results-table :results="$securityMeasures"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'security-measures.edit','delete' => 'security-measures.destroy', 'sort' => 'security-measures.update']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
