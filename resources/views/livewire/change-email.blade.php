<div>
    <x-modal id="{{ $modal }}">
        <!-- Modal body -->
        <div class="mt-4 mb-6">
            <div class="mb-4">
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ __('Change email') }}
                </p>
            </div>
            <form method="post" wire:submit.prevent="changeEmail" id="change-email">
                <div class="mb-4">
                    <x-label for="password">{{ __('Current password') }}</x-label>
                    <x-input wire:model.lazy="password" type="password" id="password" name="password"></x-input>
                    @error('password') <span class="text-red-500 italic text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="mb-4">
                    <x-label for="email">{{ __('New email') }}</x-label>
                    <x-input wire:model.lazy="email" type="text" id="email" name="email"></x-input>
                    @error('email') <span class="text-red-500 italic text-sm">{{ $message }}</span> @enderror
                </div>
            </form>
        </div>
        <x-slot name="footer">
            <footer
                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
            >
                <button
                    @click="closeModal('#{{ $modal }}')"
                    class="close-modal px-4 py-2 font-medium text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-md dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >Cancel
                </button>
                <x-button form="change-email">Accept</x-button>
            </footer>
        </x-slot>
    </x-modal>
    @if (session()->has('message'))
        <x-toast-alert id="changedEmailAlert">{{ session('message') }}</x-toast-alert>
    @endif
</div>
<script>
    window.addEventListener('emailChanged', () => {
        document.querySelector(`#{!! $modal !!} .close-modal`).click();
    });
</script>
