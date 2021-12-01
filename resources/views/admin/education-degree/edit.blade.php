<x-admin-layout>
    <form action="{{ route('education-degree.update', $education_degree->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('education-degree.edit_ed') }}</h2>
                <a class="text-blue-500" href="{{ route('education-degree.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('education-degree.ed_go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="name">{{ __("common.name") }} *</x-label>
                <x-input type="text" value="{{ $education_degree->name }}" id="name" name="name"/>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
