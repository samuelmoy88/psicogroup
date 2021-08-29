<div>
    <div class="main-min-height container mx-auto max-w-6xl p-5 gap-4">
        @if(!$validated)
        <h2 class="font-bold text-2xl mb-5">{{ __('common.confirm_request') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div class="col-span-1">
                <div class="mb-5">
                    <p class="mb-4">Hemos enviado un código de verificación de 6 cifras a {{ $consultation->email }} para confirmar la solicitud de tu cita</p>
                    <div class="mb-4 text-sm w-full">
                        <x-label class="mb-1" for="token">{{ __("common.insert_token") }} *</x-label>
                        <x-input wire:model="token" type="numeric" maxlength="6" minlength="6" id="token" name="token" placeholder="_ _ _ _ _ _"/>
                        @if($errors->has('mismatch'))
                        <div class="text-red-500 mt-2">{{ $errors->first('mismatch') }}</div>
                        @endif
                    </div>
                    <div class="mb-4">
                        <x-button class="w-full justify-center" wire:click="$emit('confirm')">
                            {{ __('common.confirm_request') }}
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        @else
        <h2 class="font-bold text-2xl mb-5">
            Solicitud de cita confirmada
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2">
            <div class="col-span-1">
                <div class="mb-5">
                    <p class="mb-4">Tu solicitud ha sido enviada al especialista, en breve se pondrá en contacto contigo. Gracias por confiar en Psico-Group.</p>
                </div>
                <div class="mb-5">
                    <a href="/" class="text-blue-500 cursor-pointer">Volver al inicio</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
