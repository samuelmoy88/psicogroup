<?php

namespace App\Http\Livewire;

use App\Models\SpecialistProfileChanges;
use Livewire\Component;

class RejectSpecialistChange extends Component
{
    public string $modal;

    public SpecialistProfileChanges $change;

    public function mount($modal)
    {
        $this->modal = $modal;
    }

    public function setChange(SpecialistProfileChanges $change)
    {
        $this->change = $change;
    }

    public function render()
    {
        return view('livewire.reject-specialist-change');
    }
}
