<x-front-layout>
    <div class="main-min-height relative overflow-hidden bg-center bg-cover"
         style="background-image: url({{ asset('images/cover.webp') }});">
        <div class="p-14 mx-auto max-w-7xl px-4 sm:p-20">
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
            <form method="GET" action="{{ route('search.index') }}" class="search-form">
                <ul class="flex flex-wrap justify-between z-10 space-y-10 lg:space-y-0">
                    <li class="relative w-full lg:w-auto lg:max-w-sm">
                        <livewire:query-search/>
                    </li>
                    <li class="relative w-full lg:w-auto lg:max-w-sm">
                        <livewire:location-search
                            :classes="'text-center border-gray-100 rounded w-full py-3 px-12 xl:px-20'"/>
                    </li>
                    <li class="w-full lg:w-auto">
                        <button type="submit"
                                class="w-full lg:w-auto text-center border-gray-100 rounded py-3 px-20 bg-brand-color text-white">
                            Buscar
                        </button>
                    </li>
                </ul>
            </form>
        </div>
        <div class="mx-auto text-center absolute right-2/4 bottom-8">
            <a href="#dna">
                <i class="animate-bounce fas fa-arrow-down text-white text-3xl"></i>
            </a>
        </div>
    </div>
    <div class="bg-gray-100">
        <div id="dna" class="max-w-4xl mx-auto px-4 py-16 sm:px-6 sm:pt-20 sm:pb-24 lg:max-w-7xl lg:pt-24 lg:px-8">
            <h2 class="text-3xl font-extrabold text-black tracking-tight">
                Nuestro ADN
            </h2>
            <p class="mt-4 max-w-3xl text-lg text-black">
                Psico-Group nace de la idea de encontrar, en un solo lugar, a los profesionales de la salud mental y ayudarlos a conectar con facilidad con sus pacientes mejorando, de esta manera, la relación que hay entre ellos.
            </p>
            <div
                class="mt-6 grid grid-cols-1 gap-x-6 gap-y-12 sm:grid-cols-2 lg:mt-8 lg:grid-cols-2 lg:gap-x-8 lg:gap-y-16">
                    <div>
                        <div>
                        </div>
                        <div class="mt-6">
                            <p class="text-base text-black">
                                Apreciamos que cada vez más personas usan las redes para buscar ayuda para resolver dificultades relacionadas con la salud mental, sin embargo, cuando llega la hora de buscar a un profesional se termina acudiendo a alguien cercano para que recomiende a un psicólogo ya que no hay un solo lugar donde se puedan buscar y elegir con confianza.
                            </p>
                        </div>
                    </div>
                    <div>
                        <div>
                        </div>
                        <div class="mt-6">
                            <p class="text-base text-black">
                                Nuestro objetivo es que los pacientes puedan disponer del profesional perfecto para sus necesidades y facilitarles la manera de conectar con ellos. Queremos que el paciente encuentre, de manera agradable, rápida y confiable a un profesional de confianza en un solo lugar.

                                Asimismo, queremos proporcionar a los profesionales y a los centros de salud un mejor acceso a sus pacientes, así como también herramientas que les ayuden a gestionar las citas con sus pacientes, mejorar la eficiencia y potenciar la presencia online.

                                Únete a nuestra red y comienza a conectar.
                            </p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</x-front-layout>
