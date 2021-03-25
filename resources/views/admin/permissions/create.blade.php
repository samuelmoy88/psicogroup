<x-admin-layout>
    <form action="{{ route('config.permissions.store') }}" method="post">
        @csrf
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('config.create_permissions') }}</h2>
                <a class="text-blue-500" href="{{ route('config.permissions.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('config.permissions_go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="name">{{ __("common.name") }} *</x-label>
                <x-input type="text" value="" id="name" name="name"/>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
