<x-admin-layout>
    <form action="{{ route('specialities.update', $speciality->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('specialities.edit_speciality') }}</h2>
                <a class="text-blue-500" href="{{ route('specialities.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('specialities.go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="title">{{ __("common.title") }} *</x-label>
                <x-input type="text" value="{{ $speciality->title }}" id="title" name="title"/>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
