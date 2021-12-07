<?php

namespace App\Http\Controllers;

use App\Http\Requests\PricingInquiryRequest;
use App\Jobs\ProcessNewPricingInquiry;
use App\Jobs\SendNewInquiryEmailToProspect;
use App\Models\User;
use App\Services\PricingInquiry;
use Illuminate\Http\Request;

class PremiumPricingInquiryController extends Controller
{
    public function index()
    {
        return view('front.pricing-inquiry.index', [
            'premiumPlans' => readPremiumPlanFromCache(),
        ]);
    }

    public function store(PricingInquiryRequest $request)
    {
        $request->validated();

        $pricingInquiry = new PricingInquiry($request);

        if ($pricingInquiry->isUserAlreadyRegistered()) {
            $user = $pricingInquiry->fetchExistingUser();
        }

        dispatch(
            new ProcessNewPricingInquiry(
                $request->all(),
                isset($user) && $user instanceof User ? $user : null,
            )
        );

        dispatch(
            new SendNewInquiryEmailToProspect(
                $request->all(),
            )
        );

        $request->session()->flash('inquiry_success', true);

        return redirect(route('front.pricing-inquiry-done'));
    }
}
