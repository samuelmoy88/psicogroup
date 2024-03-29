<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="data()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="apple-touch-icon" type="image/png" sizes="180x131" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">


        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/0333ea10da.js" crossorigin="anonymous"></script>
        @livewireStyles
        @livewire('livewire-ui-modal')
        @livewireScripts
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Desktop sidebar -->
            @auth
                <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
                    @include('layouts.sidebar')
                </aside>
                <!-- Mobile sidebar -->
                <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center" style="display: none;"></div>
                <aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden" x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu" @keydown.escape="closeSideMenu" style="display: none;">
                    @include('layouts.sidebar')
                </aside>
            @endauth
            <div class="flex flex-col flex-1 w-full overflow-y-auto">
            @auth
                @include('layouts.specialist-header')
            @endauth
                <main class="py-5 mx-3 md:mx-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
    <script src="{{ asset('js/geocoding.js') }}" defer></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7dTLZL1k_yLqGihevcj8ZFOG6dEhkduA&libraries=places">
    </script>
    <script>
        const shouldSpecialistMenuBeOpened = '{{ explode('/', Request::decodedPath())[0] === 'profile' ? 'true' : 'false' }}';
        const shouldAccountMenuBeOpened = '{{ explode('/', Request::decodedPath())[0] === 'account' ? 'true' : 'false' }}';
    </script>
    @stack('scripts')
</html>
