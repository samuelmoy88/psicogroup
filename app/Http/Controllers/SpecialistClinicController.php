<?php

namespace App\Http\Controllers;

use App\Models\ClinicSpecialist;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistClinicController extends Controller
{
    public function index()
    {

        return view('specialist.clinics.index', [
            'clinics' => auth()->user()->profile->clinics
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClinicSpecialist $clinicSpecialist
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Exception
     */
    public function destroy(User $uuid, ClinicSpecialist $clinicSpecialist)
    {
        if ($clinicSpecialist->delete()) {
            return redirect(route('specialist.clinics.index', auth()->user()->uuid))->with('success', __('specialists.delete_clinic_success'));
        }

        return redirect(route('specialist.clinics.index', auth()->user()->uuid))->with('error', __('specialists.delete_clinic_error') . $clinicSpecialist->clinic->user->fullName);
    }
}
