<div>
    <div class="table striped hovered" x-data="data()">
        <div class="thead">
            <div class="tr">
                <div class="td">{{ __('common.field') }}</div>
                <div class="td">{{ __('common.old_value') }}</div>
                <div class="td">{{ __('common.new_value') }}</div>
                <div class="td">{{ __('common.date') }}</div>
                @if(request()->routeIs('changes.show') || strpos(request()->route()->uri,'livewire/message') !== false)
                    <div class="td">{{ __('common.state') }}</div>
                    <div class="td">{{ __('common.actions') }}</div>
                @endif
            </div>
        </div>
        <div class="tbody">
            @foreach($specialist->profile->changes as $changes)
                <div class="tr">
                    <div class="td">{{ __('specialists.field_'.$changes->field) }}</div>
                    <div class="td">{{ $changes->old_value }}</div>
                    <div class="td">{{ $changes->new_value }}</div>
                    <div class="td">{{ $changes->createdReadable }}</div>
                    @if(request()->routeIs('changes.show') || strpos(request()->route()->uri,'livewire/message') !== false)
                        <div class="td">{{ __('changes-history.state_'.$changes->state) }}</div>
                        <div class="td">
                            <div class="flex items-center space-x-4 text-sm">
                                @if($changes->state !== \App\Models\SpecialistProfileChanges::STATE_APPROVED)
                                    <i title="{{ __('changes-history.approve') }}" x-on:click="openModal('#acceptChangeModal');$wire.setChangeToAccept({{$changes}})"
                                         class="cursor-pointer fas fa-check-square text-brand-color"></i>
                                @endif
                                @if($changes->state !== \App\Models\SpecialistProfileChanges::STATE_REJECTED)
                                    <i title="{{ __('changes-history.reject') }}" x-on:click="openModal('#rejectChangeModal');$wire.setChangeToReject({{$changes}})"
                                        class="cursor-pointer fas fa-times-circle text-brand-color"></i>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if(request()->routeIs('changes.show') || strpos(request()->route()->uri,'livewire/message') !== false)
        <livewire:accept-specialist-change :modal="'acceptChangeModal'"/>
        <livewire:reject-specialist-change :modal="'rejectChangeModal'"/>
        @endif
    </div>
    @if(request()->routeIs('changes.show') || strpos(request()->route()->uri,'livewire/message') !== false)
        <div class="my-4 flex flex-wrap justify-between">
            <button x-on:click="openModal('#acceptAllChanges')"
                class="inline-flex items-center px-4 py-2 bg-brand-color border border-transparent rounded-md font-medium text-white tracking-widest active:bg-purple-800 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple disabled:opacity-25 transition ease-in-out duration-150"
            >{{ __('changes-history.approve_pending_changes') }}</button>
            <button x-on:click="openModal('#contactSpecialist')" class="text-brand-color">{{ __('changes-history.notify_specialist') }}</button>
            <button x-on:click="openModal('#rejectAllChanges')" class="text-red-600">{{ __('changes-history.reject_pending_changes') }}</button>
        </div>
    @endif
    <livewire:contact-specialist :modal="'contactSpecialist'" :specialist="$specialist"/>
    <livewire:accept-all-changes :modal="'acceptAllChanges'"/>
    <livewire:reject-all-changes :modal="'rejectAllChanges'"/>
    @if(session('success'))
        <x-toast-alert id="flashMessage">
            {{ session('success') }}
        </x-toast-alert>
    @endif
</div>
<script>
    window.addEventListener('refresh', () => {
        setTimeout(() => {
            Livewire.emit('refreshComponent');
        }, 1500);
    });
</script>
