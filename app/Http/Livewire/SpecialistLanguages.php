<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialistLanguages extends Component
{
    public User $specialist;

    public int $languagesCounter = 0;

    protected array $listeners = ['addLanguage', 'removeLanguage'];

    public array $removedLanguagesList;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;

        $this->removedLanguagesList = [];
    }

    public function hydrateSpecialist()
    {
        if ($this->removedLanguagesList && $this->specialist->profile->languages) {
            foreach ($this->removedLanguagesList as $languageId) {
                $this->specialist->profile->languages = $this->specialist->profile->languages->filter(function ($education) use ($languageId) {
                    return $education->id != $languageId;
                });
            }
        }
    }

    public function addLanguage()
    {
        if ($this->languagesCounter < 0) {
            $this->languagesCounter = 1;
        } else {
            $this->languagesCounter++;
        }

    }

    public function removeLanguage($languageId = null)
    {
        if ($languageId && !$this->specialist->profile->languages->isEmpty()) {
            $this->specialist->profile->languages = $this->specialist->profile->languages->filter(function ($education) use ($languageId) {
                return $education->id != $languageId;
            });
            $this->removedLanguagesList[] = $languageId;
        } else {
            $this->languagesCounter--;
        }

        if ($this->languagesCounter < 0) {
            $this->languagesCounter = 1;
        }
    }

    public function render()
    {
        return view('livewire.specialist-languages');
    }
}
