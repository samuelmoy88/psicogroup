<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistConsultationController extends Controller
{
    public function index(User $specialist)
    {
        return view('specialist.consultations.index', [
            'consultations' => $specialist->profile->consultations
        ]);
    }

    public function show(User $specialist, Consultation $consultation)
    {
        return view('specialist.consultations.show', [
            'consultation' => $consultation
        ]);
    }
}
