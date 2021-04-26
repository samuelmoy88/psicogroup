<?php

namespace App\Http\Controllers;

use App\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = new Search();

        $specialists = $search->advancedSearch($request);

        $services = readServicesFromCache();

        $specialties = readSpecialitiesFromCache();

        $diseases = readDiseasesFromCache();

        $paymentMethods = readPaymentMethodsFromCache();

        return view('front.search.index', [
            'specialists' => $specialists,
            'services' => $services,
            'specialties' => $specialties,
            'diseases' => $diseases,
            'paymentMethods' => $paymentMethods,
        ]);
    }
}
