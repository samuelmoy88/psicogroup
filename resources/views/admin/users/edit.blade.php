<x-admin-layout>
    <form action="{{ route('config.users.update', $user->id) }}" method="post" id="updateUser">
        @csrf
        @method('PUT')
        <div class="form-card">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-xl mb-4">{{ __('config.edit_user') }}</h2>
                <a class="text-blue-500" href="{{ route('config.users.index') }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('config.users_go_back') }}</a>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4 text-sm">
                    <x-label for="first_name">{{ __("common.first_name") }} *</x-label>
                    <x-input type="text" value="{{ $user->first_name }}" id="first_name" name="first_name"/>
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="last_name">{{ __("common.last_names") }} *</x-label>
                    <x-input type="text" value="{{ $user->last_name }}" id="last_name" name="last_name"/>
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="email">{{ __("common.email") }} *</x-label>
                    <x-input type="email" value="{{ $user->email }}" id="email" name="email"/>
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="phone">{{ __("common.phone") }} *</x-label>
                    <x-input type="tel" value="{{ $user->phone }}" id="phone" name="phone"/>
                </div>
                <div class="mb-4 text-sm">
                    <x-label for="status">{{ __("common.status") }} *</x-label>
                    <select name="status" id="status" class="border border-brand-color focus:border-purple-600 bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
                        @foreach($statuses as $status)
                            <option {{ $status === $user->status ? 'selected': '' }} value="{{ $status }}">{{ __('common.status_'.$status) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4 text-sm">
                    <x-label class="mb-1">{{ __("config.roles") }} </x-label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($roles as $role)
                            <div class="capitalize">
                                <label for="{{ $role->id }}" class="cursor-pointer">
                                    <input type="hidden" name="roles[{{ $role->id }}]" value="0">
                                    <x-checkbox value="{{ $role->id }}" name="roles[{{ $role->id }}]" id="{{ $role->id }}"
                                     checked="{{ $user->roles->contains($role->id) ? true : false }}"/>
                                    <span>{{ $role->name }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="flex flex-wrap justify-between">
        <div class="mb-4 text-sm">
            <span @click="openModal('#resetPassword')" class="cursor-pointer text-blue-500">Reestablecer contraseña</span>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button form="updateUser">Guardar cambios</x-button>
        </div>
    </div>
    <livewire:admin-password-reset :modal="'resetPassword'" :user="$user"/>
</x-admin-layout>
