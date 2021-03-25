<x-admin-layout>
    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('config.users') }}</h2>
            <a class="text-blue-500" href="{{ route('config.users.create') }}">{{ __('config.new_user') }}</a>
        </div>
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            @if($admins)
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
                        @foreach($admins as $admin)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-4 py-3">{{ $admin->first_name }}</td>
                                <td class="px-4 py-3">{{ $admin->last_name }}</td>
                                <td class="px-4 py-3">{{ $admin->email }}</td>
                                <td class="px-4 py-3">{{ $admin->phone }}</td>
                                <td class="px-4 py-3">{{ $admin->roles->pluck('name')->implode(', ') }}</td>
                                <td class="px-4 py-3">{{ $admin->createdReadable }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a title="{{ __('common.edit') }}" href="{{ route('config.users.edit', $admin->id) }}">
                                            <i class="fas fa-pencil-alt text-brand-color"></i>
                                        </a>
                                        @if(count($admins) > 1)
                                        <form action="{{ route('config.users.destroy', $admin->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button title="{{ __('common.delete') }}" type="submit"
                                                    class="text-red-600"><i
                                                    class="fas fa-trash-alt text-brand-color"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @if($admins->hasPages())
                    <div
                        class="px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        {{ $admins->links() }}
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
