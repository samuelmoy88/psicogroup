<?php

namespace App\Http\Controllers;

use App\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = new Search();

        $searchResults = $search->advancedSearch($request);

        $services = readServicesFromCache();

        $specialties = readSpecialitiesFromCache();

        $diseases = readDiseasesFromCache();

        $paymentMethods = readPaymentMethodsFromCache();

        $searchedService = [];
        $searchedSpeciality = [];

        if ($request->has('service') && array_filter($request->get('service'))) {
            foreach ($request->get('service') as $service) {
                if ($services->contains('id', $service)) {
                    $searchedService[$service] = $services->firstWhere('id', $service)['title'];
                }
            }
        }

        if ($request->has('speciality') && array_filter($request->get('speciality'))) {
            foreach ($request->get('speciality') as $speciality) {
                if ($services->contains('id', $speciality)) {
                    $searchedSpeciality[$speciality] = $services->firstWhere('id', $speciality)['title'];
                }
            }
        }

        return view('front.search.index', [
            'searchResults' => $searchResults,
            'services' => $services,
            'specialties' => $specialties,
            'diseases' => $diseases,
            'paymentMethods' => $paymentMethods,
            'location' => request()->input('location') ?: '',
            'searchedService' => $searchedService,
            'searchedSpeciality' => $searchedSpeciality,
        ]);
    }
}
