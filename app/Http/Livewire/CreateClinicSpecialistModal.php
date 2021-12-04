<?php

namespace App\Http\Livewire;

use App\Models\ClinicProfile;
use App\Models\ClinicSpecialist;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use LivewireUI\Modal\ModalComponent as Component;

class CreateClinicSpecialistModal extends Component
{
    public string $q = '';

    protected $listeners = ['findSpecialist', 'addToInvitationList', 'removeFromInvitationList', 'sendInvitations'];

    public Collection $specialists;

    public array $invitationsList = [];

    public bool $noResults = false;

    public User $clinic;

    public string $started_by;

    public function mount()
    {
        $this->clinic = auth()->user();
    }

    public function render()
    {
        return view('livewire.create-clinic-specialist-modal');
    }

    public function updatedQ()
    {
        $this->findSpecialist();
    }

    public function findSpecialist()
    {
        if (!$this->q) {
            $this->noResults = true;
            return false;
        }
        $q = trim($this->q);

        /** @var Builder $query */
        $query = User::specialistProfile();

        $specialists = $query->join('specialist_profiles', 'specialist_profiles.id', '=', 'users.profile_id')
        ->where(function ($query) use ($q) {
            $explodedQ = explode(' ', $q);
            foreach ($explodedQ as $word) {
                $query->orWhere('license_number', 'LIKE', $word.'%')
                    ->orWhere('email', 'like', '%'.$word.'%')
                    ->orWhere('phone', 'like', '%'.$word.'%')
                    ->orWhere('first_name', 'like', '%'.$word.'%')
                    ->orWhere('last_name', 'like', '%'.$word.'%');
            }
        })
        ->groupBy('users.id');

        if ($this->invitationsList) {
            $specialists->whereNotIn('profile_id', array_keys($this->invitationsList));
        }

        $specialists = $specialists->get();

        if ($specialists) {
            $this->specialists = $specialists;
            return true;
        }

        $this->noResults = true;
        return false;
    }

    public function addToInvitationList($specialistId, $specialistData = [])
    {
        if (!array_key_exists($specialistId, $this->invitationsList)) {
            $this->invitationsList[$specialistId] = $specialistData;
            $this->findSpecialist();
        }
    }

    public function removeFromInvitationList($specialistId)
    {
        if (array_key_exists($specialistId, $this->invitationsList)) {
            unset($this->invitationsList[$specialistId]);
            $this->findSpecialist();
        }
    }

    public function sendInvitations()
    {
        $clinicSpecialist = new ClinicSpecialist();
        foreach ($this->invitationsList as $id => $specialist) {
            $clinicSpecialist->add($this->clinic, User::where('profile_id', $id)->first(), ClinicProfile::class);
        }

        session()->flash('message',__('clinics.invitations_sent'));

        $this->closeModal();
    }

}
