<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PremiumPlanListController extends Controller
{
    public function __invoke()
    {
        return view('front.pricing.index', [
            'premiumPlans' => readPremiumPlanFromCache()
        ]);
    }
}
