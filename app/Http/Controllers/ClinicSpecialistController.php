<?php

namespace App\Http\Controllers;

use App\Models\ClinicSpecialist;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicSpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clinic.specialists.index', [
            'specialists' => auth()->user()->profile->specialists
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param User $uuid
     * @param ClinicSpecialist $clinicSpecialist
     * @param Request $request
     * @return bool
     */
    public function update(User $uuid, ClinicSpecialist $clinicSpecialist, Request $request)
    {
        if ($clinicSpecialist->togglePremium()) {
            $message = __('clinics.premium_active_for');
            if (!$clinicSpecialist->is_premium) {
                $message = __('clinics.premium_inactive_for');
            }

            return response()->json(['message' => $message . $clinicSpecialist->specialist->user->fullName]);
        }

        return response()->json(['message' => __('clinics.premium_activation_error') . $clinicSpecialist->specialist->user->fullName]);
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
            return redirect(route('clinic.specialists.index', auth()->user()->uuid))->with('success', __('clinics.delete_specialist_success'));
        }

        return redirect(route('clinic.specialists.index', auth()->user()->uuid))->with('error', __('clinics.delete_specialist_error') . $clinicSpecialist->specialist->user->fullName);
    }
}
