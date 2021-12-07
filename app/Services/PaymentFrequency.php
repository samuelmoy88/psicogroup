<?php

namespace App\Services;

class PaymentFrequency
{

    const YEARLY_PAYMENT = 'yearly';
    const BIANNUAL_PAYMENT = 'biannual';
    const QUARTERLY_PAYMENT = 'quarterly';
    const MONTHLY_PAYMENT = 'monthly';

    const YEARLY_COEFFICIENT = 1;
    const BIANNUAL_COEFFICIENT = 2;
    const QUARTERLY_COEFFICIENT = 4;
    const MONTHLY_COEFFICIENT = 12;

    public function getFrequencies()
    {
        return \App\Models\PaymentFrequency::all();
    }
}
