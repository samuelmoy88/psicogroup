<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('specialists.specialists') }}</h2>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            @if($disputes)
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
                        @foreach($disputes as $dispute)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3 truncate" title="{{ $dispute->rating->specialist->user->first_name }} {{ $dispute->rating->specialist->user->last_name }}">
                                    {{ $dispute->rating->specialist->user->first_name }} {{ $dispute->rating->specialist->user->last_name }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $dispute->rating->patient->user->first_name }} {{ $dispute->rating->patient->user->last_name }}">
                                    {{ $dispute->rating->patient->user->first_name }} {{ $dispute->rating->patient->user->last_name }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $dispute->stateLabel }}">{{ $dispute->stateLabel }}</td>
                                <td class="px-4 py-3 truncate" title="{{ $dispute->createdReadable }}">{{ $dispute->createdReadable }}</td>
                                <td class="px-4 py-3 truncate">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a title="{{ __('common.view') }}" href="{{ route('rating-dispute.show', $dispute->id) }}">
                                            <i class="fas fa-eye text-brand-color"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($disputes->hasPages())
                    <div
                        class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        {{ $disputes->links() }}
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
