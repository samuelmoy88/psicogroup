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

if (!function_exists('cacheAllSpecialists')) {
    function cacheAllSpecialists()
    {
        foreach (\App\Models\User::specialistProfile()->get() as $user) {
            $user->saveToCache();
        }
    }
}

if (!function_exists('cacheAllEntities')) {
    function cacheAllEntities()
    {
        foreach (\App\Models\Services::orderBy('order', 'asc')->get() as $service) {
            $service->cache();
            break;
        }

        foreach (\App\Models\Speciality::orderBy('order', 'asc')->get() as $speciality) {
            $speciality->cache();
            break;
        }

        foreach (\App\Models\Disease::orderBy('order', 'asc')->get() as $disease) {
            $disease->cache();
            break;
        }

        foreach (\App\Models\Unease::orderBy('order', 'asc')->get() as $uneasiness) {
            $uneasiness->cache();
            break;
        }

        foreach (\App\Models\PaymentMethod::orderBy('order', 'asc')->get() as $paymentMethod) {
            $paymentMethod->cache();
            break;
        }

        foreach (\App\Models\SecurityMeasures::orderBy('order', 'asc')->get() as $securityMeasure) {
            $securityMeasure->cache();
            break;
        }

        foreach (\App\Models\OnlineConsultationPlatform::orderBy('order', 'asc')->get() as $securityMeasure) {
            $securityMeasure->cache();
            break;
        }
    }
}

