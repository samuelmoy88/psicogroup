<?php

namespace App\Http\Livewire;

use Livewire\Component;

class RejectAllChanges extends Component
{
    public string $modal;

    public function mount($modal)
    {
        $this->modal = $modal;
    }

    public function render()
    {
        return view('livewire.reject-all-changes');
    }
}
