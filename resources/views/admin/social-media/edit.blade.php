<x-admin-layout>
    <form action="{{ route('social-media.update', $social_media->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('social-media.edit_sm') }}</h2>
                <a class="text-blue-500" href="{{ route('social-media.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('social-media.sm_go_back') }}</a>
            </div>
            <div class="mb-4 text-sm w-full">
                <x-label for="name">{{ __("common.name") }} *</x-label>
                <x-input type="text" value="{{ $social_media->name }}" id="name" name="name"/>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
