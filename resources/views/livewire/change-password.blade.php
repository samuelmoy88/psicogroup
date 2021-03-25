<div>
    <x-modal id="{{ $modal }}">
        <!-- Modal body -->
        <div class="mt-4 mb-6">
            <div class="mb-4">
                <p class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                    {{ __('common.change_password') }}
                </p>
            </div>
            <form method="post" wire:submit.prevent="changePassword(Object.fromEntries(new FormData($event.target)))" id="change-password">
                <div class="mb-4">
                    <x-label for="current_password">{{ __('common.current_password') }}</x-label>
                    <x-input type="password" id="current_password" name="current_password"></x-input>
                    <div class="current-password hidden"><span class="text-red-500 italic text-sm"></span></div>
                </div>
                <div class="mb-4 relative" x-data="{type: 'password'}">
                    <x-label for="new_password">{{ __('common.new_password') }}</x-label>
                    <div class="relative">
                        <x-input type="password" id="new_password" name="password"></x-input>
                        <div class="absolute cursor-pointer right-2 top inset-y-1/4 show_password">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="new-password hidden"><span class="text-red-500 italic text-sm"></span></div>
                </div>
                <div class="mb-4" x-data="{type: 'password'}">
                    <x-label for="password_confirmation">{{ __('common.confirm_password') }}</x-label>
                    <div class="relative">
                        <x-input wire:change.lazy="$emit('sendRequest')" type="password" id="password_confirmation"
                                 name="password_confirmation"></x-input>
                        <div class="absolute cursor-pointer right-2 top inset-y-1/4 show_password">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="confirm-password hidden"><span class="text-red-500 italic text-sm"></span></div>
                </div>
                <div class="flex hidden password-requirements">
                    <ul class="">
                        <li class="mb-2">{{ __('common.password_requirements') }}</li>
                        <li class="text-sm mb-1 text-red-500">{{ __('common.password_requires_min') }}</li>
                        <li class="text-sm mb-1 text-red-500">{{ __('common.password_requires_upper') }}</li>
                        <li class="text-sm mb-1 text-red-500">{{ __('common.password_requires_number') }}</li>
                        <li class="text-sm mb-1 text-red-500">{{ __('common.password_requires_special') }}</li>
                    </ul>
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
                <x-button form="change-password">Accept</x-button>
            </footer>
        </x-slot>
    </x-modal>
    @if (session()->has('message'))
        <x-toast-alert id="changedPasswordAlert">{{ session('message') }}</x-toast-alert>
    @endif
</div>
<script>
    window.addEventListener('passwordChanged', () => {
        document.querySelector(`#{!! $modal !!} .close-modal`).click();
    });

    let showPassword = document.querySelectorAll('.show_password');

    for (let i = 0; i < showPassword.length; i++) {
        showPassword[i].addEventListener('click', function () {
            let type = 'password';
            if (this.previousElementSibling.type === type) {
                type = 'text';
            }
            this.previousElementSibling.type = type;
        });
    }

    Livewire.on('sendRequest', () =>{
        xhr('/user/password/validate', {
            method: 'POST',
            body: {
                currentPassword: document.getElementById('current_password').value,
                newPassword: document.getElementById('new_password').value,
                confirmPassword: document.getElementById('password_confirmation').value,
            }
        }).then((results) => {

            document.querySelector('.password-requirements').classList.remove('hidden');

            if (results.errors.currentPassword.length > 0) {
                document.querySelector('.current-password').classList.remove('hidden');
                document.querySelector('.current-password').firstElementChild.innerText = results.errors.currentPassword.shift();
            }

            if (results.errors.newPassword.length > 0) {
                document.querySelector('.new-password').classList.remove('hidden');
                document.querySelector('.new-password').firstElementChild.innerText = results.errors.newPassword.shift();
            }

            if (results.errors.confirmPassword.length > 0) {
                document.querySelector('.confirm-password').classList.remove('hidden');
                document.querySelector('.confirm-password').firstElementChild.innerText = results.errors.confirmPassword.shift();
            }
        });
    });

    let xhr = async function (url, params) {
        const response = await fetch(url, {
            method: params.method,
            mode: 'cors',
            cache: 'no-cache',
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json, text-plain, */*",
                "X-Requested-With": "XMLHttpRequest",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify(params.body)
        });

        return response.json();
    }
</script>
