<button id="submitButton" {{ $attributes->merge(['type' => 'submit', 'class' => 'loading inline-flex items-center px-4 py-2 bg-brand-color border border-transparent rounded-md font-medium text-white tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150']) }}>
    <span class="loaderSlot"></span> <span class="slot">{{ $slot }}</span>
</button>
