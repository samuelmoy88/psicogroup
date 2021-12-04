<?php

namespace App\Http\Livewire;

use App\Jobs\NotifyPatientConfirmedConsultationRequest;
use App\Models\Consultation;
use Livewire\Component;

class ChangeConsultationState extends Component
{
    public Consultation $consultation;

    public string $newState = '';

    protected $listeners = ['updateState'];

    public function mount(Consultation $consultation)
    {
        $this->consultation = $consultation;

        $this->newState = $this->consultation->state;
    }

    public function render()
    {
        return view('livewire.change-consultation-state');
    }

    public function updateState()
    {
        $this->consultation->state = $this->newState;

        if ($this->consultation->save()) {
            session()->flash('success', __('consultation.state_change_success'));
        }

        if ($this->newState === 'executed') {
            dispatch(new NotifyPatientConfirmedConsultationRequest($this->consultation));
        }

        $this->dispatchBrowserEvent('stateUpdated');
    }
}
