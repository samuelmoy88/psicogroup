<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\ScopeActives;
use App\Traits\Searchable;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
    use HasFactory, SoftDeletes, FormatDates, Sortable, Searchable, ScopeActives, Cachable;

    protected $guarded = ['id'];

    protected $searchable = ['title'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    public function specialists()
    {
        return $this->morphedByMany(
            SpecialistProfile::class,
            'profile',
            'diseases_profiles',
            'disease_id',
            'profile_id'
        );
    }

    public function clinics()
    {
        return $this->morphedByMany(
            ClinicProfile::class,
            'profile',
            'diseases_profiles',
            'disease_id',
            'profile_id'
        );
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('diseases.status_inactive');
                break;
            case 3:
                $label = __('diseases.status_deleted');
                break;
            default:
                $label = __('diseases.status_active');
                break;
        }

        return $label;
    }
}
