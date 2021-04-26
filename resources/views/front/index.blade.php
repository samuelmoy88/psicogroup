<x-front-layout>
    <div class="main-min-height relative overflow-hidden bg-center bg-cover"
         style="background-image: url({{ asset('images/des-recits-2O18Tz8QidM-unsplash.jpg') }} );">
        <div class="p-14 mx-auto max-w-7xl px-4 sm:p-24">
            <div class="text-center">
                <h1 class="text-white text-4xl tracking-tight font-extrabold sm:text-5xl md:text-6xl ">
                    {{ config('app.name') }}
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-white sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Facilitando el encuentro entre psicólogos y pacientes
                </p>
            </div>
        </div>
        <div class="rounded px-8 lg:px-16 mx-auto max-w-6xl">
            <form method="GET" action="{{ route('search.index') }}">
                <ul class="flex flex-wrap justify-between z-10 space-y-10 lg:space-y-0">
                    <li class="relative w-full lg:w-auto">
                        <livewire:query-search/>
                    </li>
                    <li class="w-full lg:w-auto">
                        <input class="text-center border-gray-100 rounded w-full py-3 px-12 xl:px-20" type="text" name="" placeholder="Donde">
                    </li>
                    <li class="w-full lg:w-auto">
                        <button type="submit" class="w-full lg:w-auto text-center border-gray-100 rounded py-3 px-20 bg-brand-color text-white">Buscar</button>
                    </li>
                </ul>
            </form>
        </div>
    </div>
    </div>
</x-front-layout>
