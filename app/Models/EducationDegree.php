<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationDegree extends Model
{
    use HasFactory, FormatDates, Sortable, Cachable;

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    public function educations()
    {
        return $this->hasMany(SpecialistEducation::class, 'level', 'id');
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('education-degree.status_inactive');
                break;
            case 3:
                $label = __('education-degree.status_deleted');
                break;
            default:
                $label = __('education-degree.status_active');
                break;
        }

        return $label;
    }
}
