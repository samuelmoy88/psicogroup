<x-admin-layout>
    <form action="{{ route('uneasiness.store') }}" method="post">
        @csrf
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('uneasiness.create_unease') }}</h2>
                <a class="text-blue-500" href="{{ route('uneasiness.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('uneasiness.go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="title">{{ __("common.title") }} *</x-label>
                <x-input type="text" value="" id="title" name="title"/>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
