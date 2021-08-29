<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('common.my_specialists') }}</h2>
        </div>
    </div>
    <div class="w-full overflow-hidden rounded-lg shadow-xs">
        @if(count($specialists) > 0)
            <div class="w-full overflow-x-auto">
                <table class="w-full bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Especialista</th>
                        <th class="px-4 py-3">Has solicitado consulta?</th>
                        <th class="px-4 py-3">Has hecho una valoración?</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialists as $specialist)
                        <tr class="text-gray-700 border-b dark:text-gray-400">
                            <td class="px-4 py-3 truncate">{{ $specialist->first_name }} {{ $specialist->last_name }}</td>
                            <td class="px-4 py-3 truncate">{{ $specialist->consultations ? 'Si ('.$specialist->consultations.')' : 'No' }}</td>
                            <td class="px-4 py-3 truncate">{{ $patient->profile->givenRatings->where('specialist_profile_id', $specialist->profile->id)->first()
                            ? 'Si'
                            : 'No' }}</td>
                            <td class="px-4 py-3 truncate">
                                @if($patient->profile->givenRatings->where('specialist_profile_id', $specialist->profile->id)->first())
                                    <a class="text-xs text-white rounded bg-brand-color py-1 px-2"
                                       href="{{ route('account.feedback.show', $patient->profile->givenRatings->where('specialist_profile_id', $specialist->profile->id)->first()->id) }}"
                                    >{{ __('common.view_rating') }}</a>
                                @else
                                <a class="text-xs text-white rounded bg-brand-color py-1 px-2"
                                    href="{{ route('account.feedback.create', [
                                    'patient' => auth()->user()->uuid,
                                    'doctor' => $specialist->uuid
                                ]) }}">{{ __('common.rate_specialist') }}</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <span>No tienes solicitudes de consultas aún.</span>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
    @if(isset($success))
        <x-alert-success>{{ $success }}</x-alert-success>
    @endif
</x-app-layout>
