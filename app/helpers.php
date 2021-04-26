<?php

if (!function_exists('isAllowedTo')) {
    function isAllowedTo(string $action)
    {
        if (!auth()->user()->can($action)) {
            return abort(403, __('common.unauthorized_action'));
        }
    }
}

if (!function_exists('readSpecialistFromCache')) {
    function readSpecialistFromCache(string $uuid) : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get($uuid);
    }
}

if (!function_exists('readServicesFromCache')) {
    function readServicesFromCache() : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Services::class);
    }
}

if (!function_exists('readSpecialitiesFromCache')) {
    function readSpecialitiesFromCache() : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Speciality::class);
    }
}

if (!function_exists('readDiseasesFromCache')) {
    function readDiseasesFromCache() : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Disease::class);
    }
}

if (!function_exists('readPaymentMethodsFromCache')) {
    function readPaymentMethodsFromCache() : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\PaymentMethod::class);
    }
}

if (!function_exists('readSecurityMeasuresFromCache')) {
    function readSecurityMeasuresFromCache() : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\SecurityMeasures::class);
    }
}


if (!function_exists('readUneasinessFromCache')) {
    function readUneasinessFromCache() : \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Unease::class);
    }
}
