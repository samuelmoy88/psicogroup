<div>
    <x-label for="state">{{ __('consultation.state') }}</x-label>
    <select name="" id="state" wire:model="newState"
        class="mb-4 border border-brand-color bg-white text-gray-900 appearance-none block w-full rounded-md py-1 px-4 focus:outline-none">
        @foreach($consultation->states() as $state => $label)
            <option value="{{ $state }}"
             {{ $consultation->state === $state ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <x-button id="submitButton" wire:click="$emit('updateState')">
        {{ __('consultation.update_state') }}
    </x-button>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</div>
<script>
    window.addEventListener('stateUpdated', () => {
        let submitButton = document.querySelectorAll('.loading');
        for (let i = 0; i < submitButton.length; i++) {
            submitButton[i].addEventListener('click', function () {

                let buttonText = submitButton[i].querySelector('.slot');
                let loaderSlot = submitButton[i].querySelector('.loaderSlot');

                buttonText.innerText = 'Actualizar estado';
                loaderSlot.innerHTML = '';

                submitButton[i].disabled = false;
            })
        }
    });
</script>
