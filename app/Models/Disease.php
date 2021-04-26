<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
    use HasFactory, SoftDeletes, FormatDates, Sortable, Cachable;

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    public function specialists()
    {
        return $this->belongsToMany(SpecialistProfile::class, 'diseases_specialist_profiles', 'disease_id', 'specialist_profile_id');
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
