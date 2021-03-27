<x-app-layout>
    <div class="form-card">
        <div class="flex justify-between mb-2">
            <h2 class="font-bold text-xl">{{ __('common.addresses') }}</h2>
            <a class="text-blue-500" href="{{ route('specialist.addresses.create', auth()->user()->username) }}">{{ __('address.add_new') }}</a>
        </div>
        @if(isset($success))
            <x-alert-success>{{ $success }}</x-alert-success>
        @endif
        @if($addresses)
            <ul class="addresses">
            @foreach($addresses as $address)
                <li class="address mb-4 border border-gray-300 rounded p-2">
                    <div class="flex justify-between">
                        <div class="flex flex-col justify-between">
                            <a class="text-blue-500 cursor-pointer" href="{{ route('specialist.addresses.edit', ['specialist' => auth()->user()->username, 'address' => $address->id]) }}">{{ $address->title }}</a>
                            <address>
                                @if($address->street) {{ $address->street }}<br/> @endif
                                @if($address->city) {{ $address->city }} @endif @if($address->zip_code) {{ $address->zip_code }} @endif
                            </address>
                        </div>
                        <div class="flex items-center">
                            <a class="text-white rounded bg-brand-color py-2 px-3" href="{{ route('specialist.addresses.edit', ['specialist' => auth()->user()->username, 'address' => $address->id]) }}">{{ __('address.edit') }}</a>
                        </div>
                    </div>
                </li>
            @endforeach
            </ul>
        @endif
    </div>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</x-app-layout>
