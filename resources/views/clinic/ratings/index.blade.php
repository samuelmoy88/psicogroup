<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('common.ratings') }}</h2>
        </div>
    </div>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        @if(count($ratings) > 0)
            <div class="w-full overflow-x-auto">
                <table class="w-full bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Paciente</th>
                        <th class="px-4 py-3">Valoración</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ratings as $rating)
                        <tr class="text-gray-700 border-b dark:text-gray-400">
                            <td class="px-4 py-3 truncate">{{ $rating->patient->user->first_name }} {{ $rating->patient->user->last_name }}</td>
                            <td class="px-4 py-3 truncate"><x-specialist-rating :rating="$rating->rating"/></td>
                            <td class="px-4 py-3 truncate">
                                <a class="text-xs text-white rounded bg-brand-color py-1 px-2"
                                    href="{{ route('clinic.ratings.show', [
                                       'uuid' => auth()->user()->uuid,
                                       'rating' => $rating->id
                                       ]) }}">Ver detalles</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <span>No tienes valoraciones aún.</span>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-app-layout>
