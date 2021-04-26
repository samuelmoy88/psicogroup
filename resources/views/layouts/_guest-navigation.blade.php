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
                <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.specialities') }}
                </a>
                <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.faq') }}
                </a>
                <div class="relative">
                    <!-- Item active: "text-gray-900", Item inactive: "text-gray-500" -->
                    <button @click="signUpOpen = !signUpOpen" type="button" class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-expanded="false">
                        <span>Regístrame</span>
                        <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <template x-if="signUpOpen">
                        <div class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0"
                             @transition(enter="transition ease-out duration-200",enter-start="opacity-0 translate-y-1",enter-end="opacity-100 translate-y-0",leave="transition ease-in duration-150",leave-start="opacity-100 translate-y-0",leave-end="opacity-0 translate-y-1")
                        >
                            <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                    <a href="{{ route('register.patient') }}" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                        <p class="text-base font-medium text-gray-900">
                                            {{ __('common.register_as_patient') }}
                                        </p>
                                    </a>
                                    <a href="{{ route('register.specialist') }}" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                        <p class="text-base font-medium text-gray-900">
                                            {{ __('common.register_as_specialist') }}
                                        </p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <a href="{{ route('login') }}" class="text-base font-medium text-gray-500 hover:text-gray-900">
                    {{ __('common.login') }}
                </a>
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
                            <a href="/" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    {{ __('common.specialities') }}
                                </div>
                            </a>
                            <a href="/" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    {{ __('common.faq') }}
                                </div>
                            </a>
                            <div class="relative p-3 -m-3 rounded-lg hover:bg-gray-50">
                                <button @click="mobileSignUpOpen = !mobileSignUpOpen" type="button" class="group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none" aria-expanded="false">
                                    <span>Regístrame</span>
                                    <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <template x-if="mobileSignUpOpen">
                                    <div class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3 px-2 w-screen max-w-xs sm:px-0"
                                         @transition(enter="transition ease-out duration-200",enter-start="opacity-0 translate-y-1",enter-end="opacity-100 translate-y-0",leave="transition ease-in duration-150",leave-start="opacity-100 translate-y-0",leave-end="opacity-0 translate-y-1")
                                    >
                                        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                                <a href="{{ route('register.patient') }}" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                                    <p class="text-base font-medium text-gray-900">
                                                        {{ __('common.register_as_patient') }}
                                                    </p>
                                                </a>
                                                <a href="{{ route('register.specialist') }}" class="-m-3 p-3 block rounded-md hover:bg-gray-50">
                                                    <p class="text-base font-medium text-gray-900">
                                                        {{ __('common.register_as_specialist') }}
                                                    </p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <a href="{{ route('login') }}" class="-m-3 p-3 flex items-center rounded-lg hover:bg-gray-50">
                                <div class="text-base font-medium text-gray-900">
                                    {{ __('common.login') }}
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
