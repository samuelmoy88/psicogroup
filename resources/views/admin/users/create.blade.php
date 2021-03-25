<x-admin-layout>
    <form action="{{ route('config.users.store') }}" method="post">
        @csrf
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('config.create_user') }}</h2>
                <a class="text-blue-500" href="{{ route('config.users.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('config.users_go_back') }}</a>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4 text-sm">
                    <x-label for="first_name">{{ __("common.first_name") }} *</x-label>
                    <x-input type="text" value="" id="first_name" name="first_name"/>
                    @error('first_name') <li class="text-sm text-red-600 mt-3">{{ $message }}</li> @enderror
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="last_name">{{ __("common.last_names") }} *</x-label>
                    <x-input type="text" value="" id="last_name" name="last_name"/>
                    @error('last_name') <li class="text-sm text-red-600 mt-3">{{ $message }}</li> @enderror
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="email">{{ __("common.email") }} *</x-label>
                    <x-input type="email" value="" id="email" name="email"/>
                    @error('email') <li class="text-sm text-red-600 mt-3">{{ $message }}</li> @enderror
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="phone">{{ __("common.phone") }} *</x-label>
                    <x-input type="tel" value="" id="phone" name="phone"/>
                    @error('phone') <li class="text-sm text-red-600 mt-3">{{ $message }}</li> @enderror
                </div>
                <div class="mb-4 text-sm">
                    <x-label class="mb-1">{{ __("config.roles") }} *</x-label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($roles as $role)
                            <div class="capitalize">
                                <label for="{{ $role->id }}" class="cursor-pointer">
                                    <x-checkbox value="{{ $role->id }}" name="roles[{{ $role->id }}]" id="{{ $role->id }}"/>
                                    <span>{{ $role->name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-admin-layout>
