<div class="py-4 text-gray-500 dark:text-gray-400">
    <a title="Inicio" class="block p-3 text-lg font-bold text-gray-800 dark:text-gray-200" href="/">
        <x-logo-horizontal/>
    </a>
    <ul class="">
        @if(auth()->user()->isSpecialist)
        <li class="relative px-6 py-3">
            @include('layouts._specialist-sidebar')
        </li>
        @endif
        @if(auth()->user()->isClinic)
        <li class="relative px-6 py-3">
            @include('layouts._clinic-sidebar')
        </li>
        @endif
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
                        <a class="w-full block {{ request()->routeIs('account.edit') ? 'text-white' : '' }}"
                           href="{{ route('account.edit') }}">Ver mi cuenta</a>
                    </li>
                    @if(auth()->user()->isPatient)
                    <li class="{{ request()->routeIs('account.consultations.*') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <a class="w-full block {{ request()->routeIs('account.consultations.*') ? 'text-white' : '' }}"
                           href="{{ route('account.consultations.index', auth()->user()->uuid) }}">Ver mis consultas</a>
                    </li>
                    <li class="{{ request()->routeIs('account.specialists.*') ? 'bg-brand-color' : '' }} rounded px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer">
                        <a class="w-full block {{ request()->routeIs('account.specialists.*') ? 'text-white' : '' }}"
                           href="{{ route('account.specialists.index', auth()->user()->uuid) }}">Ver mis especialistas</a>
                    </li>
                    @endif
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
</div>
