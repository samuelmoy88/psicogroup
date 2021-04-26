<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\ScopeActives;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Sortable;

class Speciality extends Model
{
    use HasFactory, SoftDeletes, FormatDates, Sortable, Searchable, ScopeActives, Cachable;

    protected $guarded = ['id'];

    protected $searchable = ['title'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

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
