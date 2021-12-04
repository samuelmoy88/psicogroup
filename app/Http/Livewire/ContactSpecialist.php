<?php

namespace App\Http\Livewire;

use App\Http\Controllers\JobsController;
use App\Models\User;
use Livewire\Component;

class ContactSpecialist extends Component
{
    public string $modal;

    public string $body = '';

    public User $specialist;

    protected $listeners = [
        'notifySpecialist',
        'specialistContacted',
    ];

    public function mount($modal)
    {
        $this->modal = $modal;
    }

    public function render()
    {
        return view('livewire.contact-specialist');
    }

    public function notifySpecialist()
    {
        (new JobsController)->enqueue($this->specialist, $this->body);

        $this->reset('body');

        session()->flash('success', __('changes-history.specialist_contacted'));

        $this->dispatchBrowserEvent('specialistContacted');
    }
}
