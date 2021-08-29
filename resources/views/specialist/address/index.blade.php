<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('common.consultations') }}</h2>
            <a class="text-blue-500" href="{{ route('specialist.addresses.create', auth()->user()->uuid) }}">{{ __('address.add_new') }}</a>
        </div>
        @if(isset($success))
            <x-alert-success>{{ $success }}</x-alert-success>
        @endif
        @if(count($addresses) > 0)
            <ul class="addresses">
            @foreach($addresses as $address)
                <li class="address mb-4 border border-gray-300 rounded p-2">
                    <div class="flex justify-between">
                        <div class="flex flex-col justify-between">
                            <a class="text-blue-500 cursor-pointer" href="{{ route('specialist.addresses.edit', ['uuid' => auth()->user()->uuid, 'address' => $address->id]) }}"
                                >{{ $address->clinic_name ? $address->clinic_name . ' - ' : '' }} {{ $address->title }}</a>
                            <address>
                                @if($address->street) {{ $address->street }}<br/> @endif
                                @if($address->city) {{ $address->city }} @endif @if($address->zip_code) {{ $address->zip_code }} @endif
                            </address>
                        </div>
                        <div class="flex items-center">
                            <a class="text-white rounded bg-brand-color py-2 px-3" href="{{ route('specialist.addresses.edit', ['uuid' => auth()->user()->uuid, 'address' => $address->id]) }}">{{ __('address.edit') }}</a>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        @else
            <span>No tienes consultas registradas, haz click <a href="{{ route('specialist.addresses.create', auth()->user()->uuid) }}" class="text-blue-500">aquí</a> para crear una</span>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-app-layout>
