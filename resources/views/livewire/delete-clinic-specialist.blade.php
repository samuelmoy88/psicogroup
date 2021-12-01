<div>
    <div
         class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all w-full sm:align-middle sm:p-6">
        <div class="sm:flex sm:items-start">
            <div
                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" x-description="Heroicon name: outline/exclamation"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                    {{ __('clinics.delete_specialist') }}
                </h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-500">
                        {{ __('clinics.delete_specialist_copy1') . $clinicSpecialist['user']['first_name'] . ' ' . $clinicSpecialist['user']['last_name'] }}{{ __('clinics.delete_specialist_copy2') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
            <form class="inline-flex"
                  action="{{ route('clinic.specialists.destroy', ['uuid' => auth()->user()->uuid, 'clinicSpecialist' => $clinicSpecialist['pivot']['id']]) }}"
                  method="post">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                    {{ __('common.delete') }}
                </button>
            </form>
            <button type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm"
                    wire:click="$emit('closeModal')">
                    {{ __('common.cancel') }}
            </button>
        </div>
    </div>
</div>
