<?php

namespace App\Http\Controllers;

use App\CommonHelper;
use App\Http\Requests\UpdateSpecialistRequest;
use App\Models\Disease;
use App\Models\Prefix;
use App\Models\Services;
use App\Models\SpecialistProfile;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistsProfileController extends Controller
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
     * @param User $specialist
     * @param string $uuid
     * @return void
     */
    public function show(User $specialist, string $uuid)
    {
        return view('specialist.show-profile', [
            'specialist' => $specialist,
            'dbServices' => Services::all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $specialist
     * @return \Illuminate\Http\Response
     */
    public function edit(User $specialist)
    {
        //TODO: show an alert before 'save changes' button explaining the user that he has to check everything before submitting the form
        if ($specialist->id === auth()->user()->id) {
            return view('specialist.edit-profile', [
                'specialist' => auth()->user(),
                'prefixes' => Prefix::all(),
                'specialities' => Speciality::all(),
                'diseases' => Disease::all(),
            ]);
        }
        //TODO: build a cool 404 page
        return view('404');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSpecialistRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialistRequest $request)
    {
        $request->validated();

        /** @var SpecialistProfile $specialist */
        $specialist = SpecialistProfile::find(auth()->user()->profile->id);

        $specialist->commitChanges($request);

        return redirect(route('specialist.edit', $specialist->user->username))->with('success', __('common.save_changes_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $specialist
     * @return void
     */
    public function destroy(User $specialist)
    {
        //
    }
}
