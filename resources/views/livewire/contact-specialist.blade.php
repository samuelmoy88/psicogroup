<div>
    <x-modal id="{{ $modal }}">
        <!-- Modal body -->
        <div class="mt-4 mb-6">
            <div class="mb-4">
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ __('changes-history.notify_body') }}
                </p>
            </div>
            <div class="mb-4">
                <x-textarea rows="5" wire:model.lazy="body"></x-textarea>
            </div>
        </div>
        <x-slot name="footer">
            <footer
                class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
            >
                <button
                    @click="closeModal('#{{ $modal }}')"
                    class="close-modal px-4 py-2 font-medium text-white text-gray-700 transition-colors duration-150 border border-gray-300 rounded-md dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
                >{{ __('common.cancel') }}
                </button>
                <x-button wire:click="$emit('notifySpecialist')">{{ __('common.accept') }}</x-button>
            </footer>
        </x-slot>
    </x-modal>
</div>
<script>
    window.addEventListener('specialistContacted', () => {
        document.querySelector(`#{!! $modal !!} .close-modal`).click();
        let form = document.querySelector('form');

        if (form) {
            let submitButton = document.getElementById('submitButton');
            form.addEventListener('submit', function () {
                let buttonText = document.querySelector('#submitButton .slot');
                let loaderSlot = document.querySelector('#submitButton .loaderSlot');

                buttonText.innerText = 'Guardar cambios';
                loaderSlot.innerHTML = '';

                submitButton.disabled = false;
            })
        } else {
            let submitButton = document.querySelectorAll('.loading');
            for (let i = 0; i < submitButton.length; i++) {
                submitButton[i].addEventListener('click', function () {

                    let buttonText = submitButton[i].querySelector('.slot');
                    let loaderSlot = submitButton[i].querySelector('.loaderSlot');

                    buttonText.innerText = 'Guardar cambios';
                    loaderSlot.innerHTML = '';

                    submitButton[i].disabled = false;
                })
            }
        }

    });
</script>
