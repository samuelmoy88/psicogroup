<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AcceptAllChanges extends Component
{
    public string $modal;

    public function mount($modal)
    {
        $this->modal = $modal;
    }

    public function render()
    {
        return view('livewire.accept-all-changes');
    }
}
