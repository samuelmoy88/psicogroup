<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('specialists.specialists') }}</h2>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            @if($specialists)
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
                        @foreach($specialists as $specialist)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 truncate" title="{{ $specialist->first_name }}">
                                    <div class="flex items-center text-sm">
                                        <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full" src="{{ $specialist->profile->avatarPath }}" alt="" loading="lazy">
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                        </div>
                                        <div>
                                            <p class="font-semibold">{{ $specialist->first_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 truncate" title="{{ $specialist->last_name }}">{{ $specialist->last_name }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $specialist->profile->license_number }}">{{ $specialist->profile->license_number ?: '-' }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $specialist->email }}">{{ $specialist->email }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $specialist->phone }}">{{ $specialist->phone }}</td>
                                <td class="px-4 py-3 truncate">{{ $specialist->createdReadable }}</td>
                                <td class="px-4 py-3 truncate">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a title="{{ __('common.view') }}" href="{{ route('doctors.show', $specialist->uuid) }}">
                                            <i class="fas fa-eye text-brand-color"></i>
                                        </a>
                                        @if(auth()->user()->can('doctors_delete'))
                                            <form action="{{ route('doctors.destroy', $specialist->uuid) }}" method="post">
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
                @if($specialists->hasPages())
                    <div
                        class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        {{ $specialists->links() }}
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
