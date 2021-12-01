<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialistAwards extends Component
{
    public User $specialist;

    public int $awardsCounter = 0;

    protected array $listeners = ['addAward', 'removeAward'];

    public array $removedAwardsList;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;

        $this->removedAwardsList = [];
    }

    public function hydrateSpecialist()
    {
        if ($this->removedAwardsList && $this->specialist->profile->awards) {
            foreach ($this->removedAwardsList as $educationId) {
                $this->specialist->profile->awards = $this->specialist->profile->awards->filter(function ($education) use ($educationId) {
                    return $education->id != $educationId;
                });
            }
        }
    }

    public function addAward()
    {
        if ($this->awardsCounter < 0) {
            $this->awardsCounter = 1;
        } else {
            $this->awardsCounter++;
        }

    }

    public function removeAward($educationId = null)
    {
        if ($educationId && !$this->specialist->profile->awards->isEmpty()) {
            $this->specialist->profile->awards = $this->specialist->profile->awards->filter(function ($education) use ($educationId) {
                return $education->id != $educationId;
            });
            $this->removedAwardsList[] = $educationId;
        } else {
            $this->awardsCounter--;
        }

        if ($this->awardsCounter < 0) {
            $this->awardsCounter = 1;
        }
    }

    public function render()
    {
        return view('livewire.specialist-awards');
    }
}
