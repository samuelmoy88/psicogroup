<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialistPublications extends Component
{
    public User $specialist;

    public int $publicationCounter = 0;

    protected $listeners = ['addPublication', 'removePublication'];

    public array $removedPublicationsList;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;

        $this->removedPublicationsList = [];
    }

    public function hydrateSpecialist()
    {
        if ($this->removedPublicationsList && $this->specialist->profile->publication) {
            foreach ($this->removedPublicationsList as $educationId) {
                $this->specialist->profile->publication = $this->specialist->profile->publication->filter(function ($education) use ($educationId) {
                    return $education->id != $educationId;
                });
            }
        }
    }

    public function addPublication()
    {
        if ($this->publicationCounter < 0) {
            $this->publicationCounter = 1;
        } else {
            $this->publicationCounter++;
        }

    }

    public function removePublication($educationId = null)
    {
        if ($educationId && !$this->specialist->profile->publication->isEmpty()) {
            $this->specialist->profile->publication = $this->specialist->profile->publication->filter(function ($education) use ($educationId) {
                return $education->id != $educationId;
            });
            $this->removedPublicationsList[] = $educationId;
        } else {
            $this->publicationCounter--;
        }

        if ($this->publicationCounter < 0) {
            $this->publicationCounter = 1;
        }
    }

    public function render()
    {
        return view('livewire.specialist-publications');
    }
}
