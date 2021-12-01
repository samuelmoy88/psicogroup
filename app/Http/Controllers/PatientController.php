<?php

namespace App\Http\Controllers;

use App\Models\PatientProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        isAllowedTo('patients_read');

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
        isAllowedTo('patients_read');

        return view('admin.patients.show', [
            'patient' => $patient
        ]);
    }

    public function destroy(User $patient)
    {
        isAllowedTo('patients_delete');

        $patient->profile()->delete();

        $patient->delete();

        return redirect(route('patients.index'))->with('success', __('patients.delete_success'));
    }
}
