@props(['results' => [], 'resultsAttributes' => [], 'headers' => [], 'actions' => []])

<div class="w-full overflow-hidden rounded-lg shadow-xs">
@if($results && $headers)
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
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
            @foreach($results as $result)
                <tr class="text-gray-700 dark:text-gray-400">
                @foreach($resultsAttributes as $attribute)
                @if(isset($result->{$attribute}))
                <td class="px-4 py-3">{{ $result->{$attribute} }}</td>
                @endif
                @endforeach
                @if($actions)
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                        @foreach($actions as $action => $route)
                            @switch($action)
                                @case('edit')
                                <a title="{{ __('common.edit') }}" href="{{ route($route, $result->id) }}">
                                    <i class="fas fa-pencil-alt text-brand-color"></i>
                                </a>
                                @break
                                @case('delete')
                                <form action="{{ route($route, $result->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button title="{{ __('common.delete') }}" type="submit" class="text-red-600"><i class="fas fa-trash-alt text-brand-color"></i></button>
                                </form>
                                @break
                            @endswitch
                        @endforeach
                    </div>
                </td>
                @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if($results->hasPages())
        <div
            class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
        >
            {{ $results->links() }}
        </div>
    @endif

@else
    No hay datos
@endif
</div>
