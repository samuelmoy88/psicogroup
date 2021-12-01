<button
    class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
    @click="toggleSpecialistMenu" aria-haspopup="true">
                <span class="inline-flex items-center">
                  <i class="fas fa-notes-medical"></i>
                  <span class="ml-4">Perfil</span>
                </span>
    <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
    </svg>
</button>
<template x-if="isSpecialistMenuOpen">
    <ul x-transition:enter="transition-all ease-in-out duration-300"
        x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
        x-transition:leave="transition-all ease-in-out duration-300"
        x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
        class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
        aria-label="submenu">
        <li class="{{ request()->routeIs('clinic.edit') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('clinic.edit') ? 'text-white' : '' }}"
               href="{{ route('clinic.edit', auth()->user()->uuid) }}">Editar perfil</a>
        </li>
        <li class="{{ request()->routeIs('clinic.addresses.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('clinic.addresses.*') ? 'text-white' : '' }}
            {{ request()->routeIs('clinic.addresses.*') ? 'text-white' : '' }}"
               href="{{ route('clinic.addresses.index', auth()->user()->uuid) }}">
                Direcciones
            </a>
        </li>
        <li class="{{ request()->routeIs('clinic.specialists.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('clinic.specialists.*') ? 'text-white' : '' }}
            {{ request()->routeIs('clinic.specialists.*') ? 'text-white' : '' }}"
               href="{{ route('clinic.specialists.index', auth()->user()->uuid) }}">
                Mis especialistas
            </a>
        </li>
        <li class="{{ request()->routeIs('clinic.ratings.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('clinic.ratings.*') ? 'text-white' : '' }}
            {{ request()->routeIs('clinic.ratings.*') ? 'text-white' : '' }}"
               href="{{ route('clinic.ratings.index', auth()->user()->uuid) }}">
                Valoración de mis pacientes
            </a>
        </li>
        <li class="{{ request()->routeIs('clinic.show') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('clinic.show') ? 'text-white' : '' }}"
               href="{{ route('clinic.show', ['medical_center' => auth()->user()->username, 'uuid' => auth()->user()->uuid]) }}">Ver perfil</a>
        </li>
    </ul>
</template>
