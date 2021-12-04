<?php

namespace App\Http\Livewire;

use App\Models\ClinicSpecialist;
use App\Models\SpecialistProfile;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use LivewireUI\Modal\ModalComponent as Component;

class CreateSpecialistClinicModal extends Component
{
    public string $q = '';

    protected $listeners = ['findClinic', 'addToInvitationList', 'removeFromInvitationList', 'sendInvitations'];

    public Collection $clinics;

    public array $invitationsList = [];

    public bool $noResults = false;

    public User $specialist;

    public string $started_by;

    public function mount()
    {
        $this->specialist = auth()->user();
    }

    public function render()
    {
        return view('livewire.create-specialist-clinic-modal');
    }

    public function findClinic()
    {
        if (!$this->q) {
            $this->noResults = true;
            return false;
        }
        $q = trim($this->q);

        /** @var Builder $query */
        $query = User::clinicProfile();

        $clinics = $query->where(function ($query) use ($q) {
                $explodedQ = explode(' ', $q);
                foreach ($explodedQ as $word) {
                    $query->orWhere('email', 'like', '%'.$word.'%')
                        ->orWhere('phone', 'like', '%'.$word.'%')
                        ->orWhere('first_name', 'like', '%'.$word.'%')
                        ->orWhere('last_name', 'like', '%'.$word.'%');
                }
            })
            ->groupBy('users.id');

        if ($this->invitationsList) {
            $clinics->whereNotIn('profile_id', array_keys($this->invitationsList));
        }

        $clinics = $clinics->get();

        if ($clinics) {
            $this->clinics = $clinics;
            return true;
        }

        $this->noResults = true;
        return false;
    }

    public function addToInvitationList($clinicId, $specialistData = [])
    {
        if (!array_key_exists($clinicId, $this->invitationsList)) {
            $this->invitationsList[$clinicId] = $specialistData;
            $this->findClinic();
        }
    }

    public function removeFromInvitationList($clinicId)
    {
        if (array_key_exists($clinicId, $this->invitationsList)) {
            unset($this->invitationsList[$clinicId]);
            $this->findClinic();
        }
    }

    public function sendInvitations()
    {
        $clinicSpecialist = new ClinicSpecialist();
        foreach ($this->invitationsList as $id => $clinic) {
            $clinicSpecialist->add(User::where('profile_id', $id)->first(), $this->specialist, SpecialistProfile::class);
        }

        session()->flash('message',__('clinics.invitations_sent'));

        $this->closeModal();
    }
}
