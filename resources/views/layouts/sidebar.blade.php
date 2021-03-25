<div class="py-4 text-gray-500 dark:text-gray-400">
    <a class="block ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
        <x-logo-horizontal/>
    </a>
    <ul class="mt-6">
        {{--<li class="relative px-6 py-3">
            <span class="absolute inset-y-0 left-0 w-1 bg-brand-color rounded-tr-lg rounded-br-lg"
                  aria-hidden="true"></span>
            <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
               href="{{ route('specialist.edit', auth()->user()->username) }}">
                <i class="fas fa-notes-medical"></i>
                <span class="ml-4">Mi perfil</span>
            </a>
        </li>--}}
        <li class="relative px-6 py-3">
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
                        <a class="w-full {{ request()->routeIs('specialist.edit') ? 'text-white' : '' }}"
                           href="{{ route('specialist.edit', auth()->user()->username) }}">Editar perfil</a>
                    </li>
                    <li class="{{ request()->routeIs('specialist.addresses.*') ? 'bg-brand-color' : '' }}
                        rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <a class="w-full {{ request()->routeIs('specialist.addresses.*') ? 'text-white' : '' }}
                         {{ request()->routeIs('specialist.addresses.*') ? 'text-white' : '' }}"
                           href="{{ route('specialist.addresses.index', auth()->user()->username) }}">
                            Direcciones
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('specialist.services.*') ? 'bg-brand-color' : '' }}
                        rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <a class="w-full {{ request()->routeIs('specialist.services.*') ? 'text-white' : '' }}
                         {{ request()->routeIs('specialist.services.*') ? 'text-white' : '' }}"
                           href="{{ route('specialist.services.index', auth()->user()->username) }}">
                            Servicios
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('specialist.show') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <a class="w-full {{ request()->routeIs('specialist.show') ? 'text-white' : '' }}"
                           href="{{ route('specialist.show', ['specialist' => auth()->user()->username, 'uuid' => auth()->user()->uuid]) }}">Ver perfil</a>
                    </li>
                </ul>
            </template>
        </li>
        <li class="relative px-6 py-3">
            <button
                class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                @click="toggleAccountMenu" aria-haspopup="true">
                <span class="inline-flex items-center">
                  <i class="fas fa-user-circle"></i>
                  <span class="ml-4">Cuenta</span>
                </span>
                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                </svg>
            </button>
            <template x-if="isAccountMenuOpen">
                <ul x-transition:enter="transition-all ease-in-out duration-300"
                    x-transition:enter-start="opacity-25 max-h-0" x-transition:enter-end="opacity-100 max-h-xl"
                    x-transition:leave="transition-all ease-in-out duration-300"
                    x-transition:leave-start="opacity-100 max-h-xl" x-transition:leave-end="opacity-0 max-h-0"
                    class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                    aria-label="submenu">
                    <li class="{{ request()->routeIs('account.edit') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <a class="w-full {{ request()->routeIs('account.edit') ? 'text-white' : '' }}"
                           href="{{ route('account.edit') }}">Ver mi cuenta</a>
                    </li>
                    <li class="rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit">Cerrar sesión</button>
                        </form>
                    </li>
                </ul>
            </template>
        </li>
    </ul>
    <script>
        const shouldSpecialistMenuBeOpened = '{{ explode('/', Request::decodedPath())[0] === 'profile' ? 'true' : 'false' }}';
        const shouldAccountMenuBeOpened = '{{ explode('/', Request::decodedPath())[0] === 'account' ? 'true' : 'false' }}';
    </script>
</div>
