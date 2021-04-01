<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\SpecialistProfile;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('doctors_read');

        return view('admin.specialists.index', [
            'specialists' => User::where('profile_type', SpecialistProfile::class)->latest('updated_at','DESC')->paginate(config('app.per_page')),
            'attributes' => ['first_name','last_name', 'license_number','email','phone', 'createdReadable'],
            'headers' => [
                __('common.first_name'),
                __('common.last_names'),
                __('common.license_number'),
                __('common.email'),
                __('common.phone'),
                __('common.created_at'),
                __('common.actions')
            ],
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
     * @param User $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(User $doctor)
    {
        isAllowedTo('doctors_read');

        return view('admin.specialists.show', [
            'specialist' => $doctor
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(User $doctor)
    {
        isAllowedTo('doctors_update');

        return view('admin.specialists.edit', [
            'specialist' => $doctor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        isAllowedTo('doctors_delete');

        $user->profile()->delete();

        $user->delete();

        return redirect(route('doctors.index'))->with('success', __('specialists.delete_success'));
    }
}
