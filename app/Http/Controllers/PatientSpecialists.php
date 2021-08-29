<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PatientSpecialists extends Controller
{
    public function index(User $patient)
    {
        return view('account.specialists.index', [
            'patient' => $patient,
            'specialists' => $patient->profile->specialists()
        ]);
    }
}
