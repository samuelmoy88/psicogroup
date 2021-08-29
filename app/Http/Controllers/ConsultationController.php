<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateConsultationRequest;
use App\Models\Address;
use App\Models\Consultation;
use App\Models\User;

class ConsultationController extends Controller
{
    public function create(User $doctor, Address $address)
    {
        return view('front.consultation.create', [
            'doctor' => $doctor,
            'consultation' => $address
        ]);
    }

    public function store(CreateConsultationRequest $request)
    {
        $request->validated();

        $consultation = new Consultation();

        $consultation->new($request);

        return redirect(route('consultation.confirm', ['consultation' => $consultation->id]));
    }

    public function confirm(Consultation $consultation)
    {
        //todo: if the consultation is already confirmed, load a different view
        if ($consultation->verified) {
            return view();
        }

        return view('front.consultation.confirm', [
            'consultation' => $consultation
        ]);
    }
}
