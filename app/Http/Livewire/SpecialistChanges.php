<?php

namespace App\Http\Livewire;

use App\Http\Controllers\JobsController;
use App\Jobs\NotifySpecialistAboutChange;
use App\Models\SpecialistProfileChanges;
use App\Models\User;
use Livewire\Component;

class SpecialistChanges extends Component
{
    public User $specialist;

    public SpecialistProfileChanges $change;

    public string $body = '';

    protected array $listeners = [
        'accept',
        'reject',
        'refresh',
        'acceptAll',
        'rejectAll',
        'setChange',
        'refreshComponent' => '$refresh'
    ];


    public function mount(User $specialist)
    {
        $this->specialist = $specialist;
    }

    public function getChangeToAccept(SpecialistProfileChanges $change)
    {
        $this->change = $change;

        (new AcceptSpecialistChange('acceptChangeModal'))->setChange($this->change);
    }

    public function getChangeToReject(SpecialistProfileChanges $change)
    {
        $this->change = $change;

        (new RejectSpecialistChange('rejectChangeModal'))->setChange($this->change);
    }

    public function render()
    {
        return view('livewire.specialist-changes');
    }

    public function accept()
    {
        $this->change->toggleState(SpecialistProfileChanges::STATE_APPROVED);

        $this->dispatchBrowserEvent('accepted');

        session()->flash('success', __('changes-history.accepted_message'));

        $this->dispatchBrowserEvent('refresh');
    }

    public function reject()
    {
        $this->change->toggleState(SpecialistProfileChanges::STATE_REJECTED);

        $this->dispatchBrowserEvent('rejected');

        session()->flash('success', __('changes-history.rejected_message'));

        $this->dispatchBrowserEvent('refresh');
    }

    public function acceptAll()
    {
        $this->specialist->profile->changes->each(function ($change) {
            $change->toggleState(SpecialistProfileChanges::STATE_APPROVED);
        });

        $this->dispatchBrowserEvent('acceptedAll');

        session()->flash('success', __('changes-history.accepted_all_message'));
    }

    public function rejectAll()
    {
        $this->specialist->profile->changes->each(function ($change) {
            $change->toggleState(SpecialistProfileChanges::STATE_REJECTED);
        });

        $this->dispatchBrowserEvent('rejectedAll');

        session()->flash('success', __('changes-history.rejected_all_message'));
    }

    public function setChange(SpecialistProfileChanges $change)
    {
        $this->change = $change;
    }
}
