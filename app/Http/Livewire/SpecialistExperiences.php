<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialistExperiences extends Component
{
    public User $specialist;

    public int $experiencesCounter = 0;

    protected $listeners = ['addExperience', 'removeExperience'];

    public array $removedExperiencesList;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;

        $this->removedExperiencesList = [];
    }

    public function hydrateSpecialist()
    {
        if ($this->removedExperiencesList && $this->specialist->profile->experiences) {
            foreach ($this->removedExperiencesList as $educationId) {
                $this->specialist->profile->experiences = $this->specialist->profile->experiences->filter(function ($education) use ($educationId) {
                    return $education->id != $educationId;
                });
            }
        }
    }

    public function addExperience()
    {
        if ($this->experiencesCounter < 0) {
            $this->experiencesCounter = 1;
        } else {
            $this->experiencesCounter++;
        }

    }

    public function removeExperience($educationId = null)
    {
        if ($educationId && !$this->specialist->profile->experiences->isEmpty()) {
            $this->specialist->profile->experiences = $this->specialist->profile->experiences->filter(function ($education) use ($educationId) {
                return $education->id != $educationId;
            });
            $this->removedExperiencesList[] = $educationId;
        } else {
            $this->experiencesCounter--;
        }

        if ($this->experiencesCounter < 0) {
            $this->experiencesCounter = 1;
        }
    }

    public function render()
    {
        return view('livewire.specialist-experiences');
    }
}
