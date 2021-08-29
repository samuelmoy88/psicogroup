<?php

namespace App\Models;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    use HasFactory, FormatDates;

    protected $guarded = [];

    public function user()
    {
        return $this->morphOne(User::class, 'profile');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class);
    }

    public function givenRatings()
    {
        return $this->hasMany(Rating::class);
    }

    public function specialists()
    {
        return User::specialistProfile()
            ->join('specialist_profiles', 'users.profile_id', '=', 'specialist_profiles.id')
            ->join('consultations', 'consultations.specialist_profile_id', '=', 'specialist_profiles.id')
            ->where('consultations.patient_profile_id', '=', $this->id)
            ->selectRaw('pg_users.*, COUNT(pg_consultations.id) AS consultations')
            ->groupByRaw('pg_users.id')
            ->get();
    }

    public function executedConsultations()
    {
        return $this->consultations()->where('state', 'executed');
    }

    public function verify()
    {
        $this->is_verified = 1;

        $this->save();
    }
}
