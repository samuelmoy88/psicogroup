<?php

namespace App\Models;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Sortable;

class Speciality extends Model
{
    use HasFactory, SoftDeletes, FormatDates, Sortable;

    protected $guarded = ['id'];

    public function specialists()
    {
        return $this->belongsToMany(SpecialistProfile::class, 'specialist_profiles_specialities', 'speciality_id', 'specialist_profile_id');
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('specialities.status_inactive');
                break;
            case 3:
                $label = __('specialities.status_deleted');
                break;
            default:
                $label = __('specialities.status_active');
                break;
        }

        return $label;
    }
}
