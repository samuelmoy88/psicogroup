<div>
    <x-modal id="{{ $modal }}">
        <div class="mb-6">
            <div class="mb-4">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ __('ratings.request_dispute') }}
                </p>
            </div>
            <div class="mb-4">
                <p class="text-base font-normal text-gray-700 dark:text-gray-300">
                    Por favor, explícanos de forma breve por qué está usted solicitando que se haga revisión de su valoración.
                </p>
            </div>
            <div class="mb-4">
                <x-textarea wire:model.lazy="reason"></x-textarea>
                @error('reason') <span class="text-red-500 italic text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <x-slot name="footer">
            <footer
                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
            >
                <button
                    @click="closeModal('#{{ $modal }}')"
                    class="close-modal px-4 py-2 font-medium text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-md dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >Cancelar
                </button>
                <x-button wire:click="$emit('create')" class="" type="button">{{ __('common.accept') }}</x-button>
            </footer>
        </x-slot>
    </x-modal>
    @if (session()->has('message'))
        <x-toast-alert id="flashMessage">{{ session('message') }}</x-toast-alert>
    @endif
</div>
<script>
    window.addEventListener('disputeRequested', () => {
        document.querySelector(`#{!! $modal !!} .close-modal`).click();
        setTimeout(() => {
            location.reload();
        }, 2500);
    });
</script>
