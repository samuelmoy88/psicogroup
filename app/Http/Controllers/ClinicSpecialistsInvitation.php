<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidSpecialistInvitation;
use App\Models\ClinicSpecialist;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicSpecialistsInvitation extends Controller
{
    public function store(User $uuid, string $token)
    {
        throw_if(
            !ClinicSpecialist::isValid($uuid, $token, ClinicSpecialist::SPECIALIST_STATE_PENDING),
            InvalidSpecialistInvitation::class
        );

        $invitation = ClinicSpecialist::findByToken($token)->first();

        $message = __('specialists.clinic_invitation_accept_error') . ' ' . $invitation->specialist->user->fullName;

        if ($invitation->acceptInvitation()) {
            $message = __('specialists.clinic_invitation_accepted') . ' ' . $invitation->specialist->user->fullName;
        }

        return redirect(route('clinic.specialists.index', $uuid->uuid))->with('success', $message);
    }

    public function destroy(User $uuid, string $token)
    {
        throw_if(
            !ClinicSpecialist::isValid($uuid, $token, ClinicSpecialist::SPECIALIST_STATE_PENDING),
            InvalidSpecialistInvitation::class
        );

        $invitation = ClinicSpecialist::findByToken($token)->first();

        $message = __('specialists.clinic_invitation_reject_error') . ' ' . $invitation->specialist->user->fullName;

        if ($invitation->rejectInvitation()) {
            $message = __('specialists.clinic_invitation_rejected') . ' ' . $invitation->specialist->user->fullName;
        }

        return redirect(route('clinic.specialists.index', $uuid->uuid))->with('success', $message);
    }
}
