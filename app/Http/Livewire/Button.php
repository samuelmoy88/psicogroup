<?php

namespace App\Http\Livewire;

use Illuminate\View\ComponentAttributeBag;
use Livewire\Component;

class Button extends Component
{
    public bool $disabled;

    public $attributes;

    public function mount($disabled, $attributes)
    {
        $this->disabled = $disabled;

        $this->attributes = $attributes;
    }

    public function render()
    {
        return view('livewire.button');
    }
}
