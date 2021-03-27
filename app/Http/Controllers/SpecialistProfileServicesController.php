<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Services;
use App\Models\SpecialistProfile;
use App\Models\SpecialistProfileServices;
use Illuminate\Http\Request;

class SpecialistProfileServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('specialist.services.index', ['services' => auth()->user()->profile->services]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('specialist.services.create', [
            'services' => Services::whereNotIn('id', auth()->user()->profile->services->pluck('id'))->get(),
            'addresses' => auth()->user()->addresses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user()->profile;

        if ($request->services) {
            foreach ($request->services as $service_id => $service) {
                if (isset($service['service_id'])) {
                    $addresses = null;
                    if (isset($service['addresses'])) {
                        $addresses = $service['addresses'];
                        unset($service['addresses']);
                    }
                    $user->services()->attach($service_id, $service);
                    $pivot_id = $user->services()->where('service_id', $service['service_id'])->first()->pivot->id;
                    if (isset($request->services[$service_id]) && $addresses) {
                        foreach ($addresses as $address) {
                            $dbAddress = Address::find($address);
                            $dbAddress->services()->attach($pivot_id);
                        }
                    }
                }
            }
        }

        return redirect(route('specialist.services.index', [
            'specialist' => auth()->user()->username
        ]))->with('success', __('common.save_changes_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SpecialistProfileServices  $specialistProfileServices
     * @return \Illuminate\Http\Response
     */
    public function show(Services $specialistProfileServices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SpecialistProfile $specialist
     * @param Services $service
     * @return void
     */
    public function edit(string $specialist, SpecialistProfileServices $service)
    {

        return view('specialist.services.edit', [
            'service' => $service,
            'addresses' => auth()->user()->addresses
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param string $specialist
     * @param SpecialistProfileServices $service
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(string $specialist, SpecialistProfileServices $service, Request $request)
    {
        /*$request->validate([
            'price' => 'numeric'
        ]);*/

        $service->fill($request->all());

        if ($request->services['addresses']) {
            foreach ($request->services['addresses'] as $address_id => $value) {
                $dbAddress = Address::find($address_id);
                if ($dbAddress->services->contains('id', $service->id) && !$value) {
                    $dbAddress->services()->detach($service->id);
                }
                if (!$dbAddress->services->contains('id', $service->id) && $value) {
                    $dbAddress->services()->attach($service->id);
                }
            }
        }

        if ($service->update()) {
            return redirect(route('specialist.services.index', ['specialist' => $specialist]))
                ->with('success', __('common.save_changes_success'));
        }

        return back()->with('error', __('common.update_error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $specialist
     * @param \App\Models\SpecialistProfileServices $service
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(string $specialist, SpecialistProfileServices $service)
    {
        $service->delete();

        return redirect(route('specialist.services.index', ['specialist' => $specialist]))
            ->with('success', __('services.deleted_success'));
    }
}
