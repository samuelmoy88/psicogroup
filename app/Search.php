<?php


namespace App;


use App\Models\Address;
use App\Models\ClinicProfile;
use App\Models\Disease;
use App\Models\Services;
use App\Models\SpecialistProfile;
use App\Models\Speciality;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Search
{

    public function basicSearch($param)
    {
        $results = [];

        // Search specialities by title
        $specialities = Speciality::search($param)
            ->select('title','id')
            ->orderBy('order', 'desc')
            ->limit(5)
            ->get($param)
            ->toArray();

        // Search services by title
        $services = Services::search($param)
            ->select('title','id')
            ->orderBy('order', 'desc')
            ->get($param)
            ->toArray();

        // Search diseases by title
        $diseases = Disease::search($param)
            ->select('title','id')
            ->orderBy('order', 'desc')
            ->limit(5)
            ->get($param)
            ->toArray();

        // Search specialists/clinics by names
        $specialists = User::where(function ($specialists) use ($param) {
            $explodedParam = explode(' ', $param);
            foreach ($explodedParam as $word) {
                $specialists->orWhere('first_name', 'like', '%'.$word.'%')
                    ->orWhere('last_name', 'like', '%'.$word.'%');
            }
        })
            ->searchProfessionalProfiles()
            ->select('first_name', 'last_name', 'username', 'uuid', 'profile_type')
            ->limit(5)
            ->get($param)
            ->toArray();

        // Search specialists by speciality title
        $specialistsBySpeciality = Speciality::search($param)
            ->join('profiles_specialities', function ($join) {
                $join->on('specialities.id', '=', 'profiles_specialities.speciality_id');
                $join->on('profiles_specialities.profile_type', '=', DB::raw("'".SpecialistProfile::class."'"));
            })
            ->join('users', 'users.profile_id', '=', 'profiles_specialities.profile_id')
            ->select('users.first_name', 'users.last_name', 'users.username', 'users.uuid', 'specialities.title', 'users.profile_type')
            ->limit(5)
            ->groupBy('specialities.id')
            ->get()
            ->toArray();

        // Search clinics by speciality title
        $clinicBySpeciality = Speciality::search($param)
            ->join('profiles_specialities', function ($join) {
                $join->on('specialities.id', '=', 'profiles_specialities.speciality_id');
                $join->on('profiles_specialities.profile_type', '=', DB::raw("'".ClinicProfile::class."'"));
            })
            ->join('users', 'users.profile_id', '=', 'profiles_specialities.profile_id')
            ->select('users.first_name', 'users.last_name', 'users.username', 'users.uuid', 'specialities.title', 'users.profile_type')
            ->limit(5)
            ->groupBy('specialities.id')
            ->get()
            ->toArray();

        // Search clinics by disease title
        $clinicByDisease = Disease::search($param)
            ->join('diseases_profiles', function ($join) {
                $join->on('diseases.id', '=', 'diseases_profiles.disease_id');
                $join->on('diseases_profiles.profile_type', '=', DB::raw("'".ClinicProfile::class."'"));
            })
            ->join('users', 'users.profile_id', '=', 'diseases_profiles.profile_id')
            ->select('users.first_name', 'users.last_name', 'users.username', 'users.uuid', 'diseases.title', 'users.profile_type')
            ->limit(5)
            ->groupBy('diseases.id')
            ->get()
            ->toArray();

        // Search specialists by service title
        $specialistsByService = Services::search($param)
            ->join('services_specialist_profiles', 'services.id', '=', 'services_specialist_profiles.service_id')
            ->join('users', 'users.profile_id', '=', 'services_specialist_profiles.specialist_profile_id')
            ->select('users.first_name', 'users.last_name', 'users.username', 'users.uuid', 'services.title', 'users.profile_type')
            ->limit(5)
            ->groupBy('services.id')
            ->get()
            ->toArray();

        if (count($services) > 0) {
            $results['services'] = $services;
        }

        if (count($specialities) > 0) {
            $results['specialities'] = $specialities;
        }

        if (count($diseases) > 0) {
            $results['diseases'] = $diseases;
        }

        if (count($specialists) > 0) {
            $results['specialist'] = $specialists;
        }

        if (count($specialistsBySpeciality) > 0) {
            $results['specialistBySpeciality'] = $specialistsBySpeciality;
        }

        if (count($specialistsByService) > 0) {
            $results['specialistByService'] = $specialistsByService;
        }

        if (count($clinicBySpeciality) > 0) {
            $results['clinicBySpeciality'] = $specialistsByService;
        }

        if (count($clinicByDisease) > 0) {
            $results['clinicByDisease'] = $specialistsByService;
        }

        return $results;
    }

    public function advancedSearch(Request $request)
    {
        $profileClasses = '"'. str_replace("\\", "\\\\", SpecialistProfile::class). '", "' . str_replace("\\", "\\\\", ClinicProfile::class) . '"';
        $queryBuilder = DB::table('users AS u')
            ->selectRaw(...$this->getSelectColumns())
            ->whereRaw('pg_u.profile_type IN ('.$profileClasses.')')
            ->whereRaw('pg_u.status = "active"')
            ->whereNull('u.banned_until');

        if ($request->query('service') && array_filter($request->input('service'))) {
            $queryBuilder->join('services_specialist_profiles AS ssp', 'ssp.specialist_profile_id', '=', 'u.profile_id')
                ->join('services as s', 's.id', '=', 'ssp.service_id')
                ->whereIn('s.id', $request->query('service'));
        }

        if ($request->query('speciality') && array_filter($request->input('speciality'))) {
            $queryBuilder->join('profiles_specialities AS sps', function ($join) use ($request) {
                $join->on('sps.profile_id', '=', 'u.profile_id');
                if ($request->query('profile_type')) {
                    $join->on('sps.profile_type', '=', DB::raw("'".str_replace("\\", "\\\\", SpecialistProfile::class)."'"));
                }

            })
                ->join('specialities as sp', 'sp.id', '=', 'sps.speciality_id')
                ->whereIn('sp.id', $request->query('speciality'));
        }

        if ($request->query('disease') && array_filter($request->input('disease'))) {
            $queryBuilder->join('diseases_profiles AS dsp', function ($join) use($request) {
                $join->on('dsp.profile_id', '=', 'u.profile_id');
                if ($request->query('profile_type')) {
                    $join->on('dsp.profile_type', '=', DB::raw("'".str_replace("\\", "\\\\", SpecialistProfile::class)."'"));
                }
            })
                ->join('diseases as d', 'd.id', '=', 'dsp.disease_id')
                ->whereIn('d.id', $request->query('disease'));
        }

        if ($request->query('payment')) {
            $queryBuilder->join('addresses_users AS au', 'au.user_id', '=', 'u.id')
                ->join('addresses_payment_methods as apm', 'apm.address_id', '=', 'au.address_id')
                ->join('payment_methods as pm', 'pm.id', '=', 'apm.payment_method_id')
                ->whereIn('pm.id', $request->query('payment'));
        }

        if ($request->query('is_online')) {
            $queryBuilder->join('addresses_users AS au', 'au.user_id', '=', 'u.id')
                ->join('addresses as a', 'a.id', '=', 'au.address_id')
                ->where('a.consultation_type', Address::TYPE_ONLINE);
        }

        if ($request->query('location')) {
            $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];

            $term = str_replace($reservedSymbols, '', $request->query('location'));

            $words = explode(' ', $term);

            foreach ($words as $index => $word) {
                $words[$index] = '+' . $word . '*';
            }

            $term = implode(' ',$words);
            $queryBuilder->join('addresses_users AS au', 'au.user_id', '=', 'u.id')
                ->join('addresses as a', 'a.id', '=', 'au.address_id')
                ->whereRaw("MATCH (`street`, `city`) AGAINST (? IN BOOLEAN MODE)", $term);
        }

        $results = $queryBuilder->get();
//        echo $queryBuilder->toSql();

        if ($results->count() > 0) {
            $specialists = $this->retrieveResultsFromCache($results);

            return $specialists;
        }

        return collect([]);
    }

    private function retrieveResultsFromCache($dbResults)
    {
        $specialists = [];
        foreach ($dbResults as $result) {
            $specialists[] = readProfileFromCache($result->uuid);
        }

        return collect($specialists);
    }

    private function getSelectColumns()
    {
        return [
            'distinct `pg_u`.`uuid` as uuid',
        ];
    }
}
