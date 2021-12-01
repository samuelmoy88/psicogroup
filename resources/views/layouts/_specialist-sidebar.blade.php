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
        <li class="{{ request()->routeIs('specialist.edit') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.edit') ? 'text-white' : '' }}"
               href="{{ route('specialist.edit', auth()->user()->uuid) }}">Editar perfil</a>
        </li>
        <li class="{{ request()->routeIs('specialist.addresses.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.addresses.*') ? 'text-white' : '' }}
            {{ request()->routeIs('specialist.addresses.*') ? 'text-white' : '' }}"
               href="{{ route('specialist.addresses.index', auth()->user()->uuid) }}">
                Consultas
            </a>
        </li>
        <li class="{{ request()->routeIs('specialist.services.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.services.*') ? 'text-white' : '' }}
            {{ request()->routeIs('specialist.services.*') ? 'text-white' : '' }}"
               href="{{ route('specialist.services.index', auth()->user()->uuid) }}">
                Servicios
            </a>
        </li>
        <li class="{{ request()->routeIs('specialist.clinics.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.clinics.*') ? 'text-white' : '' }}
            {{ request()->routeIs('specialist.clinics.*') ? 'text-white' : '' }}"
               href="{{ route('specialist.clinics.index', auth()->user()->uuid) }}">
                Centros médicos
            </a>
        </li>
        <li class="{{ request()->routeIs('specialist.consultations.*') ? 'bg-brand-color' : '' }} flex justify-between items-center
                        rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.consultations.*') ? 'text-white' : '' }}
            {{ request()->routeIs('specialist.consultations.*') ? 'text-white' : '' }}"
               href="{{ route('specialist.consultations.index', auth()->user()->uuid) }}">
                Solicitudes de consulta

            </a>
            {!! auth()->user()->profile->pendingConsultations() ?
            '<div class="rounded-full h-5 w-5 flex items-center justify-center bg-red-500 text-white text-xs">'.auth()->user()->profile->pendingConsultations().'</div>'
            : '' !!}
        </li>
        <li class="{{ request()->routeIs('specialist.ratings.*') ? 'bg-brand-color' : '' }}
            rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.ratings.*') ? 'text-white' : '' }}
            {{ request()->routeIs('specialist.ratings.*') ? 'text-white' : '' }}"
               href="{{ route('specialist.ratings.index', auth()->user()->uuid) }}">
                Valoración de mis pacientes
            </a>
        </li>
        <li class="{{ request()->routeIs('specialist.show') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
            <a class="w-full block {{ request()->routeIs('specialist.show') ? 'text-white' : '' }}"
               href="{{ route('specialist.show', ['specialist' => auth()->user()->username, 'uuid' => auth()->user()->uuid]) }}">Ver perfil</a>
        </li>
    </ul>
</template>
