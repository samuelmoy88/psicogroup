<x-admin-layout>
    <form action="{{ route('security-measures.update', $securityMeasure->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('security-measures.edit_sm') }}</h2>
                <a class="text-blue-500" href="{{ route('security-measures.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('security-measures.go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="title">{{ __("common.title") }} *</x-label>
                <x-input type="text" value="{{ $securityMeasure->title }}" id="title" name="title"/>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
