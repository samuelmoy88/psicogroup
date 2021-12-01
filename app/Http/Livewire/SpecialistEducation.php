<?php

namespace App\Http\Livewire;

use App\Models\EducationDegree;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SpecialistEducation extends Component
{
    public User $specialist;

    public Collection $educationLevels;

    public int $educationCounter = 0;

    protected array $listeners = ['addEducation', 'removeEducation'];

    public array $removedEducationList;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;

        $this->educationLevels = (new \App\Models\SpecialistEducation())->getEducationLevels();

        $this->removedEducationList = [];
    }

    public function hydrateSpecialist()
    {
        if ($this->removedEducationList && $this->specialist->profile->education) {
            foreach ($this->removedEducationList as $educationId) {
                $this->specialist->profile->education = $this->specialist->profile->education->filter(function ($education) use ($educationId) {
                    return $education->id != $educationId;
                });
            }
        }
    }

    public function addEducation()
    {
        if ($this->educationCounter < 0) {
            $this->educationCounter = 1;
        } else {
            $this->educationCounter++;
        }

    }

    public function removeEducation($educationId = null)
    {
        if ($educationId && !$this->specialist->profile->education->isEmpty()) {
            $this->specialist->profile->education = $this->specialist->profile->education->filter(function ($education) use ($educationId) {
                return $education->id != $educationId;
            });
            $this->removedEducationList[] = $educationId;
        } else {
            $this->educationCounter--;
        }

        if ($this->educationCounter < 0) {
            $this->educationCounter = 1;
        }
    }

    public function render()
    {
        return view('livewire.specialist-education');
    }
}
