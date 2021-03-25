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

    public function specialists()
    {
        return $this->hasManyThrough(
            User::class,
            Consultation::class,
            'specialist_profile_id',
            'profile_id',
            'id',
            'id'
        )->where('profile_type', SpecialistProfile::class);
    }
}
