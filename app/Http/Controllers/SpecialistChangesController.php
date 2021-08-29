<?php

namespace App\Http\Controllers;

use App\Models\SpecialistProfileChanges;
use App\Models\User;
use Illuminate\Http\Request;

class SpecialistChangesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('doctors_manage_changes');

        return view('admin.changes.index', [
            'changes' => SpecialistProfileChanges::with('specialist.user')
                ->latest('created_at', 'ASC')
                ->groupBy('specialist_profile_id')
                ->paginate(config('app.per_page')),
            'headers' => [
                __('common.specialist'),
                __('common.license_number'),
                __('common.field'),
                __('common.old_value'),
                __('common.new_value'),
                __('common.done_at'),
                __('common.actions')
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $doctor)
    {
        //TODO: group by field to prevent users from getting confused by multiple changes
        return view('admin.changes.show', [
            'specialist' => $doctor,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $doctor)
    {
        //
    }
}
