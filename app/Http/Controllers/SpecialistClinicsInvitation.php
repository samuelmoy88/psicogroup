<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidClinicInvitation;
use App\Models\ClinicSpecialist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialistClinicsInvitation extends Controller
{
    public function store(User $uuid, string $token)
    {
        throw_if(
            !ClinicSpecialist::isValid($uuid, $token, ClinicSpecialist::SPECIALIST_STATE_PENDING),
            InvalidClinicInvitation::class
        );

        $invitation = ClinicSpecialist::findByToken($token)->first();

        $message = __('clinics.specialist_invitation_accept_error') . $invitation->clinic->user->first_name;

        if ($invitation->acceptInvitation()) {
            $message = __('clinics.specialist_invitation_accepted') . $invitation->clinic->user->first_name;
        }

        return redirect(route('specialist.clinics.index', $uuid->uuid))->with('success', $message);
    }

    public function destroy(User $uuid, string $token)
    {
        throw_if(
            !ClinicSpecialist::isValid($uuid, $token, ClinicSpecialist::SPECIALIST_STATE_PENDING),
            InvalidClinicInvitation::class
        );

        $invitation = ClinicSpecialist::findByToken($token)->first();

        $message = __('clinics.specialist_invitation_reject_error') . $invitation->clinic->user->first_name;

        if ($invitation->rejectInvitation()) {
            $message = __('clinics.specialist_invitation_rejected') . $invitation->clinic->user->first_name;
        }

        return redirect(route('specialist.clinics.index', $uuid->uuid))->with('success', $message);
    }
}
