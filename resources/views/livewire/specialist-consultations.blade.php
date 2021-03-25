<div>
    @if(count($specialist->profile->consultations) > 0)
        <div class="table striped hovered">
            <div class="thead">
                <div class="tr">
                    <div class="td">Paciente</div>
                    <div class="td">Consulta</div>
                    <div class="td">Fecha</div>
                </div>
            </div>
            <div class="tbody">
                @foreach($specialist->profile->consultations as $consultation)
                    <div class="tr">
                        <div class="td">
                            {{ $specialist->profile->patients->firstWhere('profile_id', $consultation->patient_profile_id)->first_name }}
                            {{ $specialist->profile->patients->firstWhere('profile_id', $consultation->patient_profile_id)->last_name }}</div>
                        <div class="td">{{ $specialist->addresses->firstWhere('id', $consultation->address_id)->title }}</div>
                        <div class="td">{{ $consultation->createdReadable }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
