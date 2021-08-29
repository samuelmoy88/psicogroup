<form action="{{ route('search.index') }}" method="GET" class="flex flex-col flex-grow space-y-3">
    <div class="flex-grow flex flex-col space-y-3" x-ref="inputs">
        <div class="relative rounded bg-white py-2 px-3 border-gray-100 form-item" x-spread="input">
            <div class="flex justify-between items-center cursor-pointer form-item-container">
                <p class="form-item-title">{{ __('common.services') }} <span class="form-item-counter"></span></p><i class="fas fa-caret-down"></i>
            </div>
            <div x-ref="box" class="absolute hidden form-box-closed rounded bg-white top-12 left-0 z-10 py-2 px-3">
                <div class="flex flex-wrap space-y-4 items-start">
                    @foreach($services as $service)
                        <div class="w-full h-5 flex items-center">
                            <div class="cursor-pointer">
                                <x-label for="service-{{$service['id']}}">
                                    <x-checkbox id="service-{{$service['id']}}" name="service[]" value="{{ $service['id'] }}" class="text-sm"
                                                checked="{{ request()->input('service') && in_array($service['id'], request()->input('service')) }}"/> {{ $service['title'] }}</x-label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative rounded bg-white py-2 px-3 border-gray-100 form-item" x-spread="input">
            <div class="flex justify-between items-center cursor-pointer form-item-container">
                <p class="form-item-title">{{ __('common.specialities') }} <span class="form-item-counter"></span></p><i class="fas fa-caret-down"></i>
            </div>
            <div x-ref="box" class="absolute hidden form-box-closed rounded bg-white top-12 left-0 z-10 py-2 px-3 overflow-y-auto max-h-48">
                <div class="flex flex-wrap space-y-4 items-start">
                    @foreach($specialties as $speciality)
                        <div class="w-full h-5 flex items-center">
                            <div class="">
                                <x-label class="cursor-pointer" for="service-{{$speciality['id']}}">
                                    <x-checkbox id="service-{{$speciality['id']}}" name="speciality[]" value="{{ $speciality['id'] }}" class="text-sm"
                                                checked="{{ request()->input('speciality') && in_array($speciality['id'], request()->input('speciality')) }}"/> {{ $speciality['title'] }}</x-label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative rounded bg-white py-2 px-3 border-gray-100 form-item" x-spread="input">
            <div class="flex justify-between items-center cursor-pointer form-item-container">
                <p class="form-item-title">{{ __('common.diseases') }} <span class="form-item-counter"></span></p><i class="fas fa-caret-down"></i>
            </div>
            <div x-ref="box" class="absolute hidden form-box-closed rounded bg-white top-12 left-0 z-10 py-2 px-3 overflow-y-auto max-h-48">
                <div class="flex flex-wrap space-y-4 items-start">
                    @foreach($diseases as $disease)
                        <div class="w-full h-5 flex items-center">
                            <div class="">
                                <x-label class="cursor-pointer" for="service-{{$disease['id']}}">
                                    <x-checkbox id="service-{{$disease['id']}}" name="disease[]" value="{{ $disease['id'] }}" class="text-sm"
                                                checked="{{ request()->input('disease') && in_array($disease['id'], request()->input('disease')) }}"/> {{ $disease['title'] }}</x-label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative rounded bg-white border-gray-100 form-item" x-spread="input">
            <livewire:location-search :classes="'text-left border-gray-100 rounded w-full py-2 px-3'" :location="$location"  />
        </div>
        <div>
            Consulta online
        </div>
    </div>
    <div class="flex-shrink-0 w-full">
        <x-button type="submit w-full">{{ __('common.apply_filters') }}</x-button>
    </div>
</form>
