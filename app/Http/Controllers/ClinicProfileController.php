<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateClinicRequest;
use App\Models\ClinicProfile;
use App\Models\Disease;
use App\Models\Prefix;
use App\Models\Services;
use App\Models\SocialMedia;
use App\Models\Speciality;
use App\Models\Unease;
use App\Models\User;
use Illuminate\Http\Request;

class ClinicProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param User $clinic
     * @return \Illuminate\Http\Response
     */
    public function show(User $clinic)
    {
        return view('clinic.show-profile', [
            'clinic' => $clinic,
            'dbServices' => Services::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit(User $uuid)
    {
        if ($uuid->id === auth()->user()->id) {
            return view('clinic.edit-profile', [
                'clinic' => auth()->user(),
                'specialistsVolume' => $uuid->profile->specialistsVolume(),
                'specialities' => Speciality::orderBy('order')->get(),
                'diseases' => Disease::orderBy('order')->get(),
                'social_media' => SocialMedia::orderBy('order')->get(),
            ]);
        }
        return view('errors.404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClinicRequest $request)
    {
        $request->validated();

        /** @var ClinicProfile $clinic */
        $clinic = ClinicProfile::find(auth()->user()->profile->id);

        $clinic->commitChanges($request);

        return redirect(
            route('clinic.edit', $clinic->user->uuid)
        )->with('success', __('common.save_changes_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
