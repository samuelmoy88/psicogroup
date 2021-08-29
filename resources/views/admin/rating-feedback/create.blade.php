<x-admin-layout>
    <form action="{{ route('rating-feedback.store') }}" method="post">
        @csrf
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('rating-feedback.create_rf') }}</h2>
                <a class="text-blue-500" href="{{ route('rating-feedback.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('rating-feedback.go_back') }}</a>
            </div>
            <div class="lg:flex lg:space-x-2">
                <div class="mb-4 text-sm w-full lg:w-1/2">
                    <x-label for="title">{{ __("common.title") }} *</x-label>
                    <x-input type="text" value="" id="title" name="title"/>
                </div>
                <div class="mb-4 text-sm w-full lg:w-1/2">
                    <x-label for="type">{{ __("common.type") }} *</x-label>
                    <select name="" id="type"
                            class="mb-4 border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                        @foreach($types as $type => $label)
                            <option value="{{ $type }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
