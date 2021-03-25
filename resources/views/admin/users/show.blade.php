<x-admin-layout>
    <div class="form-card">
        <div class="flex flex-wrap justify-between">
            <h2 class="font-bold text-xl mb-4">{{ __('config.edit_user') }}</h2>
            <a class="text-blue-500" href="{{ route('config.users.index') }}">
                <i class="fas fa-chevron-circle-left"></i>
                {{ __('config.users_go_back') }}</a>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="mb-4 text-sm">
                <label class="mb-2 text-xs">{{ __("common.first_name") }}</label>
                <p class="font-medium text-base">{{ $user->first_name }}</p>
            </div>
            <div class="mb-4 text-sm">
                <label class="mb-2 text-xs">{{ __("common.last_names") }}</label>
                <p class="font-medium text-base">{{ $user->last_name }}</p>
            </div>
            <div class="mb-4 text-sm">
                <label class="mb-2 text-xs">{{ __("common.email") }}</label>
                <p class="font-medium text-base">{{ $user->email }}</p>
            </div>
            <div class="mb-4 text-sm">
                <label class="mb-2 text-xs">{{ __("common.phone") }}</label>
                <p class="font-medium text-base">{{ $user->phone }}</p>
            </div>
            <div class="mb-4 text-sm">
                <label class="mb-2 text-xs">{{ __("config.roles") }}</label>
                <div class="grid grid-cols-2 gap-4">
                    @foreach($roles as $role)
                        <div class="capitalize">
                            <label for="{{ $role->id }}" class="cursor-pointer">
                                <span>{{ $role->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <livewire:change-password :modal="'passwordModal'" />
    </div>
    <div class="flex justify-between">
        <div class="mb-4 text-sm">
            <x-label class="text-blue-500 underline cursor-pointer"
                     @click="openModal('#passwordModal')">{{ __('common.change_password') }}</x-label>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </div>
</x-admin-layout>
