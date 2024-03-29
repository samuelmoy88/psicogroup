<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\AddressAccessibility;
use App\Models\InsuranceSupport;
use App\Models\OnlineConsultationPlatform;
use App\Models\PaymentMethod;
use App\Models\Services;
use App\Models\SecurityMeasures;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('specialist.address.index',[
            'addresses' => auth()->user()->addresses()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('specialist.address.create', [
            'addressAccessibility' => AddressAccessibility::all(),
            'services' => Services::orderBy('order')->get(),
            'securityMeasures' => SecurityMeasures::orderBy('order')->get(),
            'paymentMethods' => PaymentMethod::orderBy('order')->get(),
            'onlinePlatforms' => OnlineConsultationPlatform::orderBy('order')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddressRequest $request
     * @return void
     */
    public function store(AddressRequest $request)
    {
        $request->validated();

        $address = new Address();

        $address->new($request);

        return redirect(route('specialist.addresses.index', auth()->user()->uuid))->with('success', __('common.save_changes_success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(string $uuid, Address $address)
    {
        return view('specialist.address.edit',[
            'address' => $address,
            'addressAccessibility' => AddressAccessibility::all(),
            'services' => Services::orderBy('order')->get(),
            'insuranceSupport' => InsuranceSupport::all(),
            'securityMeasures' => SecurityMeasures::orderBy('order')->get(),
            'paymentMethods' => PaymentMethod::orderBy('order')->get(),
            'onlinePlatforms' => OnlineConsultationPlatform::orderBy('order')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $uuid
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Address $address
     * @return \Illuminate\Http\Response
     */
    public function update(User $uuid, Address $address, AddressRequest $request)
    {
        $request->validated();

        $address->edit($request);

        return redirect(route('specialist.addresses.index', $uuid->uuid))->with('success', __('common.save_changes_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $uuid
     * @param \App\Models\Address $address
     * @return void
     * @throws \Exception
     */
    public function destroy(User $uuid, Address $address)
    {
        $address->delete();

        return redirect(route('specialist.addresses.index', $uuid->uuid))->with('success', __('address.delete_success'));
    }
}
