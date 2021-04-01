<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('common.services') }}</h2>
            <a class="text-blue-500" href="{{ route('specialist.services.create', auth()->user()->uuid) }}">{{ __('services.add') }}</a>
        </div>
        @if(isset($success))
            <x-alert-success>{{ $success }}</x-alert-success>
        @endif
        @if(count($services) > 0)
            <ul class="addresses">
                @foreach($services as $service)
                    <li class="address mb-4 border border-gray-300 rounded p-3">
                        <div class="flex justify-between">
                            <div class="flex flex-col justify-between">
                                <a class="text-blue-500 cursor-pointer" href="{{ route('specialist.services.edit', ['uuid' => auth()->user()->uuid, 'service' => $service->pivot->id]) }}">{{ $service->title }}</a>
                                @if($service->pivot->description)
                                    <p>{{ $service->pivot->description }}</p>
                                @endif
                            </div>
                            <div class="flex items-center">
                                <a class="text-white rounded bg-brand-color py-2 px-3"
                                   href="{{ route('specialist.services.edit', ['uuid' => auth()->user()->uuid, 'service' => $service->pivot->id]) }}"
                                >{{ __('common.edit') }}</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <span>No tienes servicios registrados, haz click <a href="{{ route('specialist.services.create', auth()->user()->uuid) }}" class="text-blue-500">aquí</a> para crear uno</span>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="newSpecialistService">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-app-layout>
