<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        isAllowedTo('doctors_read');

        return view('admin.patients.index', [
            'patients' => User::where('profile_type', PatientProfile::class)->latest('updated_at','DESC')->paginate(config('app.per_page')),
            'attributes' => ['first_name','last_name', 'email','phone', 'createdReadable'],
            'headers' => [
                __('common.first_name'),
                __('common.last_names'),
                __('common.email'),
                __('common.phone'),
                __('common.created_at'),
                __('common.actions')
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $patient
     * @return Response
     */
    public function show(User $patient)
    {
        isAllowedTo('doctors_read');

        return view('admin.patients.show', [
            'patient' => $patient
        ]);
    }
}
