@props(['id' => ''])
<div>
    <div class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
         x-show="modals['#{{ $id }}']"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
    >
        <!-- Modal -->
        <div role="dialog" id="{{ $id }}"
             x-show="modals['#{{ $id }}']"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 transform translate-y-1/2"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0  transform translate-y-1/2"
             @click.away="closeModal('#{{ $id }}')"
             @keydown.escape="closeModal('#{{ $id }}')"
             class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
        >
            <!--Modal header. -->
            <header class="flex justify-end">
                <button @click="closeModal('#{{ $id }}')" aria-label="close"
                        class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
                >
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" role="img" aria-hidden="true">
                        <path
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                        ></path>
                    </svg>
                </button>
            </header>
            <!--Modal body. -->
            {{ $slot }}
            <div>
                <!--Modal footer. -->
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
