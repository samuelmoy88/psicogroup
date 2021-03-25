<x-admin-layout>
    <div class="text-right mb-4">
        <a class="text-blue-500" href="{{ route('changes.index') }}">
            <i class="fas fa-chevron-circle-left"></i> {{ __('changes-history.go_back') }}</a>
    </div>
    <div class="form-card">
        <div class="mb-4">
            <h2 class="font-bold text-xl">{{ __('changes-history.changes_history')
         .' '. $specialist->first_name . ' ' . $specialist->last_name }}</h2>
        </div>
        @if(count($specialist->profile->changes) > 0)
            <livewire:specialist-changes :specialist="$specialist" :body="''"/>
        @endif
    </div>
</x-admin-layout>
