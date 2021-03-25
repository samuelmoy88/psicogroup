<x-app-layout>
    <form action="{{ route('specialist.services.store', auth()->user()->username) }}" method="post">
        @csrf
        <div class="form-card" x-ref="services">
            <h2 class="font-bold text-xl">{{ __('Your services') }}</h2>
            <p class="text-bold text-black mb-4">Hemos seleccionado para usted una lista de los servicios más populares
                de su especialidad. Por favor, marque los que usted realiza.</p>
            <div class="mt-4 mb-4 services_block">
                @foreach($services as $key => $service)
                    <div class="p-4 mb-4 text-sm w-full flex flex-wrap space-x-4 flex-col md:flex-row bg-gray-100">
                        <div>
                            <i class="fas fa-sort cursor-pointer handle"></i>
                        </div>
                        <div class="flex-1 space-y-2">
                            <label class="flex items-center mb-2 cursor-pointer">
                                <x-checkbox name="services[{{ $service->id }}][service_id]" value="{{ $service->id }}"/>
                                <span class="ml-2">{{ $service->title }}</span>
                            </label>
                            <x-textarea rows="2" placeholder="{{ __('Add details about the service so patients want to choose you when looking for a specialist ') }}" name="services[{{ $service->id }}][description]"></x-textarea>
                        </div>
                        <div class="flex flex-wrap space-x-4 items-start">
                            <label class="flex items-center mb-2 cursor-pointer">
                                <x-checkbox name="services[{{ $service->id }}][price_from]" value="1"/>
                                <span class="ml-2">{{ __('From') }}</span>
                            </label>
                            <div class="relative text-gray-500">
                                <x-input type="number" value="" id="" name="services[{{ $service->id }}][price]"/>
                                <button class="absolute inset-y-0 right-0 rounded-r-md inline-flex items-center px-4 py-2 bg-brand-color border border-transparent font-medium text-white tracking-widest active:bg-purple-800 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple disabled:opacity-25 transition ease-in-out duration-150">S/</button>
                            </div>
                        </div>
                        @if($addresses)
                            <div class="mt-2 flex flex-wrap w-full space-x-4">
                                <p class="w-full text-bold text-black mb-4">{{ __('Consultations for this service') }}</p>
                                @foreach($addresses as $address)
                                    <label class="flex items-center mb-2 cursor-pointer">
                                        <x-checkbox name="services[{{ $service->id }}][addresses][]" value="{{ $address->id }}"/>
                                        <span class="ml-2">{{ $address->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-4 text-sm text-right">
            <x-button>Guardar cambios</x-button>
        </div>
    </form>
</x-app-layout>
