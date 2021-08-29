<x-app-layout>
    <div class="form-card mb-4">
        <div class="flex flex-wrap justify-between">
            <h2 class="font-bold text-lg mb-4">{{ __('common.specialist_data') }}</h2>
        </div>
        <div class="table striped hovered">
            <div class="thead">
                <div class="tr">
                    <div class="td">Especialista</div>
                    <div class="td">Teléfono</div>
                    <div class="td">Email</div>
                    <div class="td">Primera visita</div>
                </div>
            </div>
            <div class="tbody">
                <div class="tr">
                    <div class="td">
                        {{ $consultation->specialist->user->first_name }}
                        {{ $consultation->specialist->user->last_name }}</div>
                    <div class="td">{{ $consultation->specialist->user->phone }}</div>
                    <div class="td">{{ $consultation->specialist->user->email }}</div>
                    <div class="td">{{ $consultation->first_visit ? __('common.yes') : __('common.no') }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-card mb-4">
        <div class="flex flex-wrap justify-between">
            <h2 class="font-bold text-lg mb-4">{{ __('common.consultation_data') }}</h2>
        </div>
        <div class="table striped hovered">
            <div class="thead">
                <div class="tr">
                    <div class="td">Consulta</div>
                    <div class="td">Servicio</div>
                    <div class="td">Solicitada el</div>
                </div>
            </div>
            <div class="tbody">
                <div class="tr">
                    <div class="td">{{ $consultation->address->title }}</div>
                    <div class="td">{{ $consultation->service->title }}</div>
                    <div class="td">{{ $consultation->createdReadable }}</div>
                </div>
            </div>
        </div>
    </div>
    @if($consultation->comments)
        <div class="form-card mb-4">
            <div class="flex flex-wrap justify-between">
                <h2 class="font-bold text-lg mb-4">{{ __('common.comments') }}</h2>
            </div>
            <div class="">
                {{ $consultation->comments }}
            </div>
        </div>
    @endif
</x-app-layout>
