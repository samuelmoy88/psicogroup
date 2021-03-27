<x-app-layout>
    <form action="{{ route('specialist.services.update', ['specialist' => auth()->user()->username, 'service' => $service->id]) }}" method="post" id="edit_service">
        @csrf
        @method('PUT')
        <div class="form-card" x-ref="services">
            <div class="flex flex-wrap justify-between mb-4">
                <h2 class="font-bold text-xl">{{ $service->services->title  }}</h2>
                <a class="text-blue-500" href="{{ route('specialist.services.index', auth()->user()->username) }}">
                    <i class="fas fa-chevron-circle-left"></i>
                    {{ __('services.go_back') }}</a>
            </div>
            <div class="mt-4 mb-4 services_block">
                <div class="p-4 mb-4 text-sm w-full flex flex-wrap flex-col md:flex-row bg-gray-100">
                    <div class="flex-1 space-y-2">
                        <label class="flex items-center mb-2 cursor-pointer">{{ __('common.description') }}</label>
                        <x-textarea rows="2" placeholder="{{ __('services.service_details') }}" name="description">{{ $service->description }}</x-textarea>
                    </div>
                    <div class="flex flex-wrap space-x-4 items-start">
                        <label class="flex items-center mb-2 cursor-pointer">
                            <x-checkbox name="price_from" checked="{{ $service->price_from == 1 ? true : false }}" value="1"/>
                            <span class="ml-2">{{ __('common.from') }}</span>
                        </label>
                        <div class="relative text-gray-500">
                            <x-input type="text" value="{{ $service->price }}" id="" name="price"/>
                            <button class="absolute inset-y-0 right-0 rounded-r-md inline-flex items-center px-4 py-2 bg-brand-color border border-transparent font-medium text-white tracking-widest active:bg-purple-800 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple disabled:opacity-25 transition ease-in-out duration-150">S/</button>
                        </div>
                    </div>
                    @if($addresses)
                        <div class="mt-4 flex flex-wrap w-full">
                            <p class="w-full text-bold text-black mb-4">{{ __('services.service_consultations') }}</p>
                            @foreach($addresses as $address)
                                <label class="flex items-center mb-2 cursor-pointer">
                                    <x-input type="hidden" name="services[addresses][{{ $address->id }}]" value="0"/>
                                    <x-checkbox class="mr-2" name="services[addresses][{{ $address->id }}]" value="1" checked="{{ $address->services->contains('id', $service->id) ? 'checked' : '' }}"/>
                                    <span class="mr-2">{{ $address->title }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
    <div class="control_buttons flex justify-between">
        <div class="mb-4 text-sm text-right">
            <form method="post" action="{{ route('specialist.services.destroy', ['specialist' => auth()->user()->username, 'service' => $service->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600">{{ __('services.delete') }}</button>
            </form>
        </div>
        <div class="mb-4 text-sm text-right">
            <x-button type="submit" form="edit_service">{{ __('common.save_changes') }}</x-button>
        </div>
    </div>
    @if(session('error'))
        <x-toast-error-alert id="errorUpdatingSpecialistService">
            {{ session('error') }}
        </x-toast-error-alert>
    @endif
</x-app-layout>
