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
            <tbody {{ $actions && isset($actions['sort']) ? "id=sortable" : '' }}
                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
            @foreach($results as $result)
                <tr class="text-gray-700 dark:text-gray-400" @if(array_key_exists('sort', $actions)) {!! in_array('title', $resultsAttributes) ? 'data-title="'.$result->title.'"' : "" !!}
                    data-route="{{ route('services.update', $result->id, false) }}" data-id="{{ $result->id }}" @endif>
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
                                @case('sort')
                                <i class="fas fa-sort cursor-pointer handle text-brand-color" title="{{ __('common.sort') }}" aria-hidden="true"></i>
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
    @if($results instanceof \Illuminate\Pagination\LengthAwarePaginator &&$results->hasPages())
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
