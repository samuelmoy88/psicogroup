<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SpecialistCertificates extends Component
{
    public User $specialist;

    public int $certificatesCounter = 0;

    protected $listeners = ['addCertificate', 'removeCertificate'];

    public array $removedCertificatesList;

    public int $expires = 0;

    public function mount(User $specialist)
    {
        $this->specialist = $specialist;

        $this->removedCertificatesList = [];
    }

    public function hydrateSpecialist()
    {
        if ($this->removedCertificatesList && $this->specialist->profile->certificates) {
            foreach ($this->removedCertificatesList as $educationId) {
                $this->specialist->profile->certificates = $this->specialist->profile->certificates->filter(function ($education) use ($educationId) {
                    return $education->id != $educationId;
                });
            }
        }
    }

    public function addCertificate()
    {
        if ($this->certificatesCounter < 0) {
            $this->certificatesCounter = 1;
        } else {
            $this->certificatesCounter++;
            $this->dispatchBrowserEvent('checkIfExpirationIsChecked');
        }

    }

    public function removeCertificate($educationId = null)
    {
        if ($educationId && !$this->specialist->profile->certificates->isEmpty()) {
            $this->specialist->profile->certificates = $this->specialist->profile->certificates->filter(function ($education) use ($educationId) {
                return $education->id != $educationId;
            });
            $this->removedCertificatesList[] = $educationId;
        } else {
            $this->certificatesCounter--;
        }

        if ($this->certificatesCounter < 0) {
            $this->certificatesCounter = 1;
        }
    }

    public function render()
    {
        return view('livewire.specialist-certificates');
    }
}
