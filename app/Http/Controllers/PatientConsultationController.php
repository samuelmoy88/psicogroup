<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;

class PatientConsultationController extends Controller
{
    public function index(User $patient)
    {
        $consultations = $patient->profile->consultations;

        return view('account.consultations.index', [
            'consultations' => $consultations
        ]);
    }


    public function show(User $patient, Consultation $consultation)
    {
        $consultations = $patient->profile->consultations;

        return view('account.consultations.show', [
            'consultation' => $consultation
        ]);
    }
}
