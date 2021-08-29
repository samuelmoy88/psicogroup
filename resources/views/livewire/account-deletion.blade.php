<div>
    <x-modal id="{{ $modal }}">
        <div class="mb-6">
            <div class="mb-4">
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ __('common.delete_account') }}
                </p>
            </div>
            <div class="deletion-copy {{ $codeHasBeenSent ? 'hidden' : '' }}">
                <div class="mb-4">
                    <p class="text-base font-normal text-gray-700 dark:text-gray-300">
                        Lamentamos mucho que ya no quieras formar parte de nuestra red.
                    </p>
                </div>
                <div class="mb-4">
                    <p class="text-base font-normal text-gray-700 dark:text-gray-300">
                        Si deseas seguir adelante con el proceso, haz clic en el botón "Continuar". Enviaremos un
                        código
                        de verificación a la dirección de email asociada con tu cuenta.
                    </p>
                </div>
            </div>
            <div class="deletion-code {{ $codeHasBeenSent ? '' : 'hidden' }}">
                <p class="mb-4">Hemos enviado un código de verificación de 6 cifras a {{ auth()->user()->email }}
                    para confirmar la eliminación de tu cuenta</p>
                <div class="mb-4 text-sm w-full">
                    <x-label class="mb-1" for="verificationCode">{{ __("common.insert_token") }} *</x-label>
                    <x-input wire:model="verificationCode" type="numeric" maxlength="6" minlength="6" id="verificationCode" name="verificationCode"
                             placeholder="_ _ _ _ _ _"/>
                    @if($errors->has('mismatch'))
                        <div class="text-red-500 mt-2">{{ $errors->first('mismatch') }}</div>
                    @endif
                </div>
            </div>
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
                <x-button  class="do-send-code {{ $codeHasBeenSent ? 'hidden' : '' }}" type="button">{{ __('common.continue') }}</x-button>
                <x-button wire:click="$emit('deleteAccount')" class="do-delete {{ $codeHasBeenSent ? '' : 'hidden' }}" type="button">{{ __('common.accept') }}</x-button>
            </footer>
        </x-slot>
    </x-modal>
    @if (session()->has('message'))
        <x-toast-alert id="flashMessage">{{ session('message') }}</x-toast-alert>
    @endif
</div>
<script>
    window.addEventListener('emailChanged', () => {
        document.querySelector(`#{!! $modal !!} .close-modal`).click();
    });

    document.querySelector('.do-send-code').addEventListener('click', function () {
        Livewire.emit('sendVerificationCode');
        document.querySelector('.deletion-copy').classList.toggle('hidden');
        document.querySelector('.deletion-code').classList.toggle('hidden');
        document.querySelector('.do-send-code').classList.toggle('hidden');
        document.querySelector('.do-delete').classList.toggle('hidden');
    });
</script>
