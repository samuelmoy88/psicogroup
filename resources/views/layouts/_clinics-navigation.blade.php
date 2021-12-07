<div class="relative bg-white w-full" x-data="loginDropdown()">
    <div class="flex justify-between items-center px-4 sm:px-6 md:justify-start md:space-x-10">
        <div>
            <a href="/" class="block lg:w-60 xl:w-72">
                <span class="sr-only">{{ config('app.name') }}</span>
                <x-logo-horizontal/>
            </a>
        </div>
        <div class="-mr-2 -my-2 md:hidden">
            <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                <span class="sr-only">Abrir menú</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
        <div class="hidden md:flex-1 md:flex md:items-center md:justify-end">
            <nav class="flex space-x-10">
                <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.home') }}
                </a>
                <a href="{{ route('clinic.edit', auth()->user()->uuid) }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    Mi perfil
                </a>
                <a href="{{ route('front.faq') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.faq') }}
                </a>
                <a href="{{ route('front.pricing') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.pricing') }}
                </a>
                <div class="text-base font-medium text-gray-500 hover:text-gray-900">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="text-base font-medium text-gray-500 hover:text-gray-900">Cerrar sesión</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>
    <template x-if="isMobileMenuOpen">
        <div class="z-10 absolute -top-5 inset-x-0 p-2 transition transform origin-top-right md:hidden"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
                <div class="pt-5 pb-6 px-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-logo-small class="h-8 w-auto"></x-logo-small>
                        </div>
                        <div class="-mr-2">
                            <button @click="isMobileMenuOpen = !isMobileMenuOpen" type="button"
                                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                <span class="sr-only">Close menu</span>
                                <!-- Heroicon name: outline/x -->
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="mt-6">
                        <nav class="grid gap-6">
                            <a href="/" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    {{ __('common.home') }}
                                </div>
                            </a>
                            <a href="{{ route('clinic.edit', auth()->user()->uuid) }}" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    Mi perfil
                                </div>
                            </a>
                            <a href="{{ route('front.faq') }}" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    {{ __('common.faq') }}
                                </div>
                            </a>
                            <a href="{{ route('front.pricing') }}" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    {{ __('common.pricing') }}
                                </div>
                            </a>
                            <div class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit" class="text-base font-medium text-gray-500 hover:text-gray-900">Cerrar sesión</button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
