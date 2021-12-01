<?php

namespace App\Models;

use App\Jobs\SendClinicSpecialistInvitations;
use App\Jobs\SendSpecialistClinicInvitations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClinicSpecialist extends Model
{
    use HasFactory;

    const SPECIALIST_STATE_PENDING = 'pending';
    const SPECIALIST_STATE_ACCEPTED = 'accepted';
    const SPECIALIST_STATE_REJECTED = 'rejected';

    protected $guarded = ['id'];

    public function clinic()
    {
        return $this->belongsTo(
            ClinicProfile::class,
            'clinic_id',
            'id'
        );
    }

    public function specialist()
    {
        return $this->belongsTo(
            SpecialistProfile::class,
            'specialist_id',
            'id'
        );
    }

    public static function isValid(User $user, string $token, string $state = '')
    {
        $builder = self::query();

        if ($user->isSpecialist) {
            $builder->where('specialist_id', $user->profile_id);
        } else {
            $builder->where('clinic_id', $user->profile_id);
        }

        $builder->where('invitation_token', $token);

        if ($state) {
            $builder->where('state', $state);
        }

        return $builder->first() ? true : false;
    }

    public function acceptInvitation()
    {
        return $this->toggleInvitation(self::SPECIALIST_STATE_ACCEPTED);
    }

    public function rejectInvitation()
    {
        return $this->toggleInvitation(self::SPECIALIST_STATE_REJECTED);
    }

    public function toggleInvitation(string $state)
    {
        $this->state = $state;
        return $this->save() ? true : false;
    }

    public function specialistsStates()
    {
        return [
            self::SPECIALIST_STATE_PENDING,
            self::SPECIALIST_STATE_ACCEPTED,
            self::SPECIALIST_STATE_REJECTED,
        ];
    }

    public function scopeFindByToken($query, string $token)
    {
        return $query->where('invitation_token', $token);
    }

    public function togglePremium()
    {
        $this->is_premium = !$this->is_premium;

        return $this->save();
    }

    public function generateInvitationToken()
    {
        return sha1(Str::random(32) . microtime(true));
    }

    public function sendInvitations(User $user, string $token, string $startedBy)
    {
        if ($startedBy === ClinicProfile::class) {
            return dispatch(new SendClinicSpecialistInvitations(
                auth()->user(),
                $user,
                $token
            ));
        } else {
            return dispatch(new SendSpecialistClinicInvitations(
                auth()->user(),
                $user,
                $token
            ));
        }

    }

    public function add(User $clinic, User $specialist, string $startedBy)
    {
        $token = $this->generateInvitationToken();
        self::create([
            'clinic_id' => $clinic->profile_id,
            'specialist_id' => $specialist->profile_id,
            'state' => self::SPECIALIST_STATE_PENDING,
            'invitation_token' => $token,
            'started_by' => $startedBy
        ]);

        return $this->sendInvitations($clinic, $token, $startedBy);
    }
}
