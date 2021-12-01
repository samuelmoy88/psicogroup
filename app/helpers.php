<?php

if (!function_exists('isAllowedTo')) {
    function isAllowedTo(string $action)
    {
        if (!auth()->user()->can($action)) {
            return abort(403, __('common.unauthorized_action'));
        }
    }
}

if (!function_exists('readRatingFeedbackFromCache')) {
    function readRatingFeedbackFromCache(): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\RatingFeedback::class);
    }
}

if (!function_exists('readPositiveRatingFeedbackFromCache')) {
    function readPositiveRatingFeedbackFromCache(): \Illuminate\Support\Collection
    {
        return readRatingFeedbackFromCache()->where('type', 'positive');
    }
}

if (!function_exists('readNegativeRatingFeedbackFromCache')) {
    function readNegativeRatingFeedbackFromCache(): \Illuminate\Support\Collection
    {
        return readRatingFeedbackFromCache()->where('type', 'negative');
    }
}

if (!function_exists('readProfileFromCache')) {
    function readProfileFromCache(string $uuid): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get($uuid);
    }
}

if (!function_exists('readServicesFromCache')) {
    function readServicesFromCache(): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Services::class);
    }
}

if (!function_exists('readSpecialitiesFromCache')) {
    function readSpecialitiesFromCache(): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Speciality::class);
    }
}

if (!function_exists('readDiseasesFromCache')) {
    function readDiseasesFromCache(): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\Disease::class);
    }
}

if (!function_exists('readPaymentMethodsFromCache')) {
    function readPaymentMethodsFromCache(): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\PaymentMethod::class);
    }
}

if (!function_exists('readSecurityMeasuresFromCache')) {
    function readSecurityMeasuresFromCache(): \Illuminate\Support\Collection
    {
        return cache()
            ->store(config('cache.default'))
            ->get(\App\Models\SecurityMeasures::class);
    }
}


if (!function_exists('readUneasinessFromCache')) {
    function readUneasinessFromCache(): \Illuminate\Support\Collection
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

if (!function_exists('cacheAllClinics')) {
    function cacheAllClinics()
    {
        foreach (\App\Models\User::clinicProfile()->get() as $user) {
            $user->saveToCache();
        }
    }
}

if (!function_exists('cacheAllProfiles')) {
    function cacheAllProfiles()
    {
        cacheAllSpecialists();
        cacheAllClinics();
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

        foreach (\App\Models\RatingFeedback::orderBy('order', 'asc')->get() as $ratingFeedback) {
            $ratingFeedback->cache();
            break;
        }
    }
}

if (!function_exists('languagesList')) {
    function languagesList()
    {
        return [
            "aa" => "Afar",
            "ab" => "Abjasio",
            "af" => "Africaans",
            "am" => "Amárico",
            "ar" => "Árabe",
            "as" => "Asamés",
            "ay" => "Aymara",
            "az" => "azerí",
            "ba" => "Bashkir",
            "be" => "bielorruso",
            "bg" => "búlgaro",
            "bh" => "Bihari",
            "bi" => "Bislama",
            "bn" => "bengalí",
            "bo" => "Tibetano",
            "br" => "Bretón",
            "ca" => "Catalán",
            "co" => "Córcega",
            "cs" => "Checo",
            "cy" => "Galés",
            "da" => "Danés",
            "de" => "Alemán",
            "div" => "Divehi",
            "dz" => "Bután",
            "el" => "Griego",
            "en" => "Inglés",
            "eo" => "Esperanto",
            "es" => "Español",
            "et" => "Estonio",
            "eu" => "Vasco",
            "fa" => "farsi",
            "fi" => "finlandés",
            "fj" => "Fiji",
            "fo" => "Feroés",
            "fr" => "Francés",
            "fy" => "Frisón",
            "ga" => "Irlandés",
            "gd" => "Gaélico",
            "gl" => "Gallego",
            "gn" => "Guaraní",
            "gu" => "Gujarati",
            "ha" => "Hausa",
            "he" => "hebreo",
            "hi" => "Hindi",
            "hr" => "Croata",
            "hu" => "Húngaro",
            "hy" => "Armenio",
            "ia" => "Interlingua",
            "id" => "indonesio",
            "ie" => "Interlingual",
            "ik" => "Inupiak",
            "in" => "Indonesio",
            "is" => "Islandés",
            "it" => "Italiano",
            "iw" => "Hebreo",
            "ja" => "Japonés",
            "ji" => "Yiddish",
            "jw" => "Javanés",
            "ka" => "Georgiano",
            "kk" => "Kazajo",
            "kl" => "Groenlandés",
            "km" => "Camboyano",
            "kn" => "Kannada",
            "ko" => "Coreano",
            "kok" => "Konkani",
            "ks" => "Cachemira",
            "ku" => "Kurdo",
            "ky" => "Kirguiz",
            "kz" => "kirguís",
            "la" => "Latino",
            "ln" => "Lingala",
            "lo" => "Laothian",
            "ls" => "Esloveno",
            "lt" => "Lituano",
            "lv" => "Letón",
            "mg" => "Malgache",
            "mi" => "Maorí",
            "mk" => "FYRO Macedonio",
            "ml" => "Malayalam",
            "mn" => "Mongol",
            "mo" => "Moldavo",
            "mr" => "Marathi",
            "ms" => "Malayo",
            "mt" => "Maltés",
            "my" => "Birmano",
            "na" => "Nauru",
            "ne" => "Nepalí (India)",
            "nl" => "Holandés",
            "no" => "Noruego",
            "oc" => "Occitano",
            "oy" => "Oriya",
            "pa" => "Punjabi",
            "pl" => "Polaco",
            "ps" => "Pashto / Pushto",
            "pt" => "Portugués",
            "pt-br" => "Portugués (Brasil)",
            "qu" => "Quechua",
            "rm" => "Rhaeto-Romanic",
            "rn" => "Kirundi",
            "ro" => "Rumano",
            "ru" => "Ruso",
            "rw" => "Kinyarwanda",
            "sa" => "Sánscrito",
            "sb" => "Sorbio",
            "sd" => "Sindhi",
            "sg" => "Sangro",
            "sh" => "Serbocroata",
            "si" => "Singhalese",
            "sk" => "Eslovaco",
            "sl" => "Esloveno",
            "sm" => "Samoano",
            "sn" => "Shona",
            "so" => "Somalí",
            "sq" => "Albanés",
            "sr" => "Serbio",
            "ss" => "Siswati",
            "st" => "Sesotho",
            "su" => "Sundanés",
            "sv" => "Sueco",
            "sw" => "Swahili",
            "sx" => "Sutu",
            "syr" => "Siríaco",
            "ta" => "Tamil",
            "te" => "Telugu",
            "tg" => "Tayiko",
            "th" => "Tailandés",
            "ti" => "Tigrinya",
            "tk" => "Turcomano",
            "tl" => "Tagalo",
            "tn" => "Tswana",
            "to" => "Tonga",
            "tr" => "Turco",
            "ts" => "Tsonga",
            "tt" => "Tártaro",
            "tw" => "Twi",
            "uk" => "Ucraniano",
            "ur" => "Urdu",
            "us" => "Inglés",
            "uz" => "Uzbeko",
            "vi" => "vietnamita",
            "vo" => "Volapuk",
            "wo" => "Wolof",
            "xh" => "Xhosa",
            "yi" => "Yiddish",
            "yo" => "Yoruba",
            "zh" => "Chino",
            "zu" => "Zulú"
        ];
    }
}

if (!function_exists('monthsOfTheYear')) {
    function monthsOfTheYear()
    {
        return [
            '01' => trans('common.january'),
            '02' => trans('common.february'),
            '03' => trans('common.march'),
            '04' => trans('common.april'),
            '05' => trans('common.may'),
            '06' => trans('common.june'),
            '07' => trans('common.july'),
            '08' => trans('common.august'),
            '09' => trans('common.september'),
            '10' => trans('common.october'),
            '11' => trans('common.november'),
            '12' => trans('common.december'),
        ];
    }
}

if (!function_exists('yearsForDropdown')) {
    function yearsForDropdown($yearsToSubtract = 100, $operation = 'add')
    {
        $threshold = 0;

        $currentYear = date('Y');

        $years = [];

        while ($threshold <= $yearsToSubtract) {
            $years[] = $currentYear;
            if ($operation !== 'add') {
                $currentYear--;
            } else {
                $currentYear++;
            }

            $threshold++;
        }

        return $years;
    }
}
