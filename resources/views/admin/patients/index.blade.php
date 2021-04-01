<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('patients.patients') }}</h2>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            @if($patients)
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap table-fixed">
                        <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                        >
                            @foreach($headers as $header)
                                <th class="px-4 py-3">{{ $header }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody
                            class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                        >
                        @foreach($patients as $patient)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 truncate" title="{{ $patient->first_name }}">
                                    {{ $patient->first_name }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $patient->last_name }}">{{ $patient->last_name }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $patient->email }}">{{ $patient->email }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $patient->phone }}">{{ $patient->phone }}</td>
                                <td class="px-4 py-3 truncate">{{ $patient->createdReadable }}</td>
                                <td class="px-4 py-3 truncate">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a title="{{ __('common.view') }}" href="{{ route('patients.show', $patient->uuid) }}">
                                            <i class="fas fa-eye text-brand-color"></i>
                                        </a>
                                        @if(auth()->user()->can('patients_delete'))
                                        <form action="{{ route('patients.destroy', $patient->uuid) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button title="{{ __('common.delete') }}" type="submit" class="text-red-600"><i class="fas fa-trash-alt text-brand-color"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($patients->hasPages())
                    <div
                        class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        {{ $patients->links() }}
                    </div>
                @endif
            @else
                No hay datos
            @endif
        </div>
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-admin-layout>
