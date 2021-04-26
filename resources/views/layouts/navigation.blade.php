<header class="w-full h-16 lg:h-24 flex flex-wrap items-center">
    @if(!Auth::check())
        @include('layouts._guest-navigation')
    @else
        @if(auth()->user()->isSpecialist)
            @include('layouts._specialists-navigation')
        @elseif(auth()->user()->isPatient)
            @include('layouts._patients-navigation')
        @else
            @include('layouts._guest-navigation')
        @endif
    @endif
</header>

