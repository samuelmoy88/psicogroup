<x-app-layout>
    <form action="{{ route('account.update') }}" method="post">
        @csrf
        @method('PUT')
        @if(isset($success))
            <x-alert-success>{{ $success }}</x-alert-success>
        @endif
        <div class="form-card">
            <h2 class="font-bold text-xl mb-4">Configuración de tu cuenta</h2>
            <div class="mb-4 text-sm">
                <x-label for="first_name">{{ __('First name') }} *</x-label>
                <x-input type="text" value="{{ $user->first_name }}" id="first_name" name="first_name" placeholder=""/>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="last_name">{{ __('Last name') }} *</x-label>
                <x-input type="text" value="{{ $user->last_name }}" id="last_name" name="last_name" placeholder=""/>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="phone">{{ __('Phone number') }} *</x-label>
                <x-input type="tel" value="{{ $user->phone }}" id="phone" name="phone" placeholder=""/>
            </div>
            <div class="mb-4 text-sm">
                <x-label >{{ __('Email') }}</x-label>
                <x-label >
                    {{ $user->email }} -
                    <span class="text-blue-500 underline cursor-pointer" @click="openModal('#emailModal')">{{ __('common.change_email') }}</span>
                </x-label>
            </div>
            <div class="mb-4 text-sm">
                <x-label for="">{{ __('Password') }} </x-label>
                <x-label class="text-blue-500 underline cursor-pointer" @click="openModal('#passwordModal')">{{ __('common.change_password') }}</x-label>
            </div>
        </div>
        <div class="flex justify-between">
            <button type="button" @click="openModal('#deleteAccount')" class="text-red-500 underline">{{ __('common.delete_account') }}</button>
            <x-button>Guardar cambios</x-button>
        </div>

    </form>
    @if(session('success'))
        <x-toast-alert id="changedProfileAlert">{{ session('success') }}</x-toast-alert>
    @endif
    <livewire:account-deletion :modal="'deleteAccount'"/>
    <livewire:change-password :modal="'passwordModal'"/>
    <livewire:change-email :modal="'emailModal'" />
</x-app-layout>
