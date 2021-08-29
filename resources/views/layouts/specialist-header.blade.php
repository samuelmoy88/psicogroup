<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div
        class="container flex items-center justify-between md:justify-end h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
    >
        <!-- Mobile hamburger -->
        <button
            class="p-1 -ml-1 mr-5 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu"
            aria-label="Menu"
        >
            <svg
                class="w-6 h-6"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    fill-rule="evenodd"
                    d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </button>
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <li class="relative hidden md:block">
                <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.home') }}
                </a>
            </li>
            <li class="relative hidden md:block">
                <a href="{{ route('front.faq') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.faq') }}
                </a>
            </li>
            <!-- Profile menu -->
            <li class="relative">
                <button
                    class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                    @click="toggleProfileMenu"
                    @keydown.escape="closeProfileMenu"
                    aria-label="Account"
                    aria-haspopup="true"
                >
                    <i class="fas fa-user-circle text-xl text-brand-color"></i>
                </button>
                <template x-if="isProfileMenuOpen">
                    <ul
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @click.away="closeProfileMenu"
                        @keydown.escape="closeProfileMenu"
                        class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        aria-label="submenu"
                    >
                        <li class="flex hover:bg-gray-100 hover:text-gray-800 px-2 py-1 md:hidden">
                            <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                {{ __('common.home') }}
                            </a>
                        </li>
                        <li class="flex hover:bg-gray-100 hover:text-gray-800 px-2 py-1 md:hidden">
                            <a href="{{ route('front.faq') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                                {{ __('common.faq') }}
                            </a>
                        </li>
                        <li class="flex hover:bg-gray-100 hover:text-gray-800 px-2 py-1">
                            @if(auth()->user()->isSpecialist)
                            <a href="{{ route('specialist.show', ['specialist' => auth()->user()->username, 'uuid' => auth()->user()->uuid]) }}">
                                <i class="fas fa-id-badge text-lg mr-2"></i> Perfil
                            </a>
                            @endif
                        </li>
                        <li class="flex hover:bg-gray-100 hover:text-gray-800 px-2 py-1">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit"><i class="fas fa-sign-out-alt text-lg mr-2"></i> Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </template>
            </li>
        </ul>
    </div>
</header>
