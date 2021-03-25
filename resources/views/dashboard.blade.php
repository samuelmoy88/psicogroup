<x-app-layout>
    <div class="container mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Bienvenido {{ $user->first_name }} {{ $user->last_name }}
        </h2>
    </div>
</x-app-layout>
