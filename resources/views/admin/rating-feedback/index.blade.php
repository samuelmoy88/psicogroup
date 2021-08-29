<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('rating-feedback.rating_feedback') }}</h2>
            <a class="text-blue-500" href="{{ route('rating-feedback.create') }}">{{ __('rating-feedback.new_rf') }}</a>
        </div>
        <x-results-table :results="$ratings_feedback"
                         :resultsAttributes="$attributes"
                         :headers="$headers"
                         :actions="['edit' => 'rating-feedback.edit','delete' => 'rating-feedback.destroy', 'sort' => 'rating-feedback.sort']"/>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
    @if(session('error'))
        <x-toast-error-alert id="errorDeletingFeedback">
            {{ session('error') }}
        </x-toast-error-alert>
    @endif
</x-admin-layout>
