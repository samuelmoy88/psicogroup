<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SpecialistService extends Component
{
    public array $services;

    protected $listeners = [
        'serviceLoaded' => 'loadService'
    ];

    public string $label = '';

    public Collection $addresses;

    protected $rules = [
        'label' => 'required|max:255'
    ];

    public function mount($addresses)
    {
        $this->services = [];

        $this->addresses = $addresses;
    }

    public function render()
    {
        return view('livewire.specialist-service');
    }

    public function loadService()
    {
        if (count($this->services) == 0) {
            $this->services[]['label'] = '';
            return;
        }

        $this->validate();

        $this->services[]['label'] = $this->label;

        $this->reset('label');

    }


}
