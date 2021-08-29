<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('common.consultations') }}</h2>
        </div>
    </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
        @if(count($consultations) > 0)
            <div class="w-full overflow-x-auto">
                <table class="w-full bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                        <th class="px-4 py-3">Paciente</th>
                        <th class="px-4 py-3">Consulta</th>
                        <th class="px-4 py-3">Servicio</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($consultations as $consultation)
                        <tr class="text-gray-700 border-b dark:text-gray-400">
                            <td class="px-4 py-3 truncate">{{ $consultation->first_name }} {{ $consultation->last_name }}</td>
                            <td class="px-4 py-3 truncate">{{ $consultation->address->title }}</td>
                            <td class="px-4 py-3 truncate">{{ $consultation->service->title }}</td>
                            <td class="px-4 py-3 truncate">{{ $consultation->stateLabel }}</td>
                            <td class="px-4 py-3 truncate"><a class="text-xs text-white rounded bg-brand-color py-1 px-2"
                                   href="{{ route('specialist.consultations.show', [
                                       'doctor' => auth()->user()->uuid,
                                       'consultation' => $consultation->id
                                       ]) }}">Ver detalles</a></td>
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
