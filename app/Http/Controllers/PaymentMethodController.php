<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        isAllowedTo('payment_methods_read');

        return view('admin.payment-methods.index', [
            'paymentMethods' => PaymentMethod::orderBy('order')->get(),
            'attributes' => ['title', 'statusLabel', 'createdReadable'],
            'headers' => [
                __('common.title'),
                __('common.status'),
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
        isAllowedTo('payment_methods_create');

        return view('admin.payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        isAllowedTo('payment_methods_create');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        if (PaymentMethod::create($request->all())) {
            return redirect(route('payment-methods.index'))->with('success', __('payment-methods.created_success'));
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        isAllowedTo('payment_methods_update');

        return view('admin.payment-methods.edit', [
            'paymentMethod' => $paymentMethod
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        isAllowedTo('payment_methods_update');

        $request->validate([
            'title' => 'required|max:255|string'
        ]);

        $paymentMethod->fill($request->all());

        if ($paymentMethod->update()) {
            return redirect(route('payment-methods.index'))->with('success', __('payment-methods.updated_success'));
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentMethod  $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        isAllowedTo('payment_methods_delete');

        $paymentMethod->delete();

        return redirect(route('payment-methods.index'))->with('success', __('payment-methods.deleted_success'));
    }
}
