<?php

namespace App\Http\Controllers;

use App\Models\ClinicProfile;
use App\Models\ClinicSpecialist;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicInvitationResend extends Controller
{
    public function __invoke(User $doctor, Request $request)
    {
        $request->validate([
            'invitation_token' => ['string'],
        ]);

        /** @var ClinicSpecialist $clinicSpecialist */
        $clinicSpecialist = ClinicSpecialist::where('invitation_token', $request->get('invitation_token'))->first();

        $clinicSpecialist->sendInvitations($doctor, $request->get('invitation_token'), ClinicProfile::class);

        return redirect(route('clinic.specialists.index', $doctor->uuid))->with('success', __('clinics.invitations_resent') . $doctor->fullName);
    }
}
