<?php

namespace App\Http\Livewire;

use LivewireUI\Modal\ModalComponent;

class DeleteClinicSpecialist extends ModalComponent
{
    public array $clinicSpecialist;

    public function mount($clinicSpecialist)
    {
        $this->clinicSpecialist = $clinicSpecialist;
    }

    public function render()
    {
        return view('livewire.delete-clinic-specialist');
    }
}
