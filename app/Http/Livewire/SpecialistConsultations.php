<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialistConsultations extends Component
{
    public User $specialist;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;
    }

    public function render()
    {
        return view('livewire.specialist-consultations');
    }
}
