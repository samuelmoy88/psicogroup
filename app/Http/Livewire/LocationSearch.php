<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LocationSearch extends Component
{
    public string $classes = '';

    public ?string $location = '';

    protected $listeners = ['autofillSelection'];

    public function mount(string $classes, $location = '')
    {
        $this->classes = $classes;

        $this->location = $location;
    }

    public function render()
    {
        return view('livewire.location-search');
    }

    public function autofillSelection()
    {

    }
}
