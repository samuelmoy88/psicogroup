<div class="rounded bg-white p-4">
    <div class="flex">
        <div>
            <img class="object-cover" src="{{ asset('images/not_found.webp') }}" alt="no results found">
        </div>
        <div>
            <p class="font-bold text-xl">{{ __('common.no_search_results_copy') }}</p>
            @if($searchedService || $searchedSpeciality)
                <div class="mt-4 text-gray-400">
                    <p>Tu búsqueda ha sido:</p>
                    @if($searchedService)
                    <p>Servicio: {{ implode(', ', $searchedService) }}</p>
                    @endif
                    @if($searchedSpeciality)
                    <p>Especialidad: {{ implode(', ', $searchedSpeciality) }}</p>
                    @endif
                    @if($location)
                    <p>En: {{ $location }}</p>
                    @endif
                </div>
            @endif
            @if($searchedService || $searchedSpeciality || $location)
                <div class="mt-4">
                    <p>Puedes probar buscando:</p>
                    <ul class="list-disc">
                        @if($searchedService)
                        @foreach($searchedService as $key => $_service)
                            <li><a class="cursor-pointer text-blue-500" href="{{ route('search.index', ['service' => [$key]]) }}">{{ $_service }}</a></li>
                        @endforeach
                        @endif
                        @if($searchedSpeciality)
                        @foreach($searchedSpeciality as $key => $_speciality)
                            <li><a class="cursor-pointer text-blue-500" href="{{ route('search.index', ['speciality' => [$key]]) }}">{{ $_speciality }}</a></li>
                        @endforeach
                        @endif
                        @if(!request()->query('is_online'))
                            <li><a class="cursor-pointer text-blue-500" href="{{ route('search.index', ['is_online' => 1]) }}">Consulta online</a></li>
                        @endif
                        <li>Ampliar tu búsqueda modificando algún filtro</li>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
