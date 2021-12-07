<?php

namespace App\Http\Controllers;

use App\Http\Requests\PremiumPlanRequest;
use App\Models\PaymentFrequency;
use App\Models\PremiumPlan;
use Illuminate\Http\Request;

class PremiumPlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.premium-plans.index', [
            'premiumPlans' => PremiumPlan::orderBy('order')->get(),
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
        return view('admin.premium-plans.new', [
            'paymentFrequencies' => PaymentFrequency::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PremiumPlanRequest $request)
    {
        $request->validated();

        $premiumPlan = new PremiumPlan();

        if ($premiumPlan->new($request)) {
            return redirect(route('premium-plan.edit', $premiumPlan->id))->with('success', __('premium-plans.create_success'));
        }
        return back()->with('error', __('premium-plans.create_error'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PremiumPlan  $premiumPlan
     * @return \Illuminate\Http\Response
     */
    public function show(PremiumPlan $premiumPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PremiumPlan  $premiumPlan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(PremiumPlan $premiumPlan)
    {
        return view('admin.premium-plans.edit', [
            'premiumPlan' => $premiumPlan,
            'paymentFrequencies' => PaymentFrequency::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PremiumPlanRequest $request
     * @param \App\Models\PremiumPlan $premiumPlan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(PremiumPlanRequest $request, PremiumPlan $premiumPlan)
    {
        $request->validated();

        if ($premiumPlan->commitChanges($request)) {
            return redirect(route('premium-plan.index'))->with('success', __('premium-plans.update_success'));
        }

        return back()->with('error', __('premium-plans.update_error'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PremiumPlan  $premiumPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PremiumPlan $premiumPlan)
    {
        if ($premiumPlan->remove()) {
            return back()->with('success', __('premium-plans.delete_success'));
        }

        return back()->with('error', __('premium-plans.delete_error'));
    }
}
