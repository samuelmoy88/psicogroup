<?php

namespace App\Http\Controllers;

use App\Models\ClinicSpecialist;
use App\Models\SpecialistProfile;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistClinicInvitationResend extends Controller
{
    public function __invoke(User $clinic, Request $request)
    {
        $request->validate([
            'invitation_token' => ['string'],
        ]);

        /** @var ClinicSpecialist $clinicSpecialist */
        $clinicSpecialist = ClinicSpecialist::where('invitation_token', $request->get('invitation_token'))->first();

        $clinicSpecialist->sendInvitations($clinic, $request->get('invitation_token'), SpecialistProfile::class);

        return redirect(route('specialist.clinics.index', $clinic->uuid))->with('success', __('clinics.invitations_resent') . $clinic->fullName);
    }
}
