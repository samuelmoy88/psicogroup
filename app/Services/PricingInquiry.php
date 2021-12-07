<?php

namespace App\Services;

use App\Http\Requests\PricingInquiryRequest;
use App\Models\User;

class PricingInquiry
{
    private PricingInquiryRequest $pricingInquiryRequest;

    const PRICING_INQUIRY_RECIPIENT_EMAIL = 'ventas@psico-group.com';

    public function __construct(PricingInquiryRequest $request)
    {
        $this->pricingInquiryRequest = $request;
    }

    public function isUserAlreadyRegistered()
    {
        $user = User::where('email', $this->pricingInquiryRequest->get('email'))->first();

        if ($user) {
            return true;
        }

        return false;
    }

    public function fetchExistingUser()
    {
        return User::where('email', $this->pricingInquiryRequest->get('email'))->first();
    }
}
