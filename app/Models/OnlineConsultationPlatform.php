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

class OnlineConsultationPlatform extends Model
{
    use HasFactory, SoftDeletes, FormatDates, Sortable, Searchable, ScopeActives, Cachable;

    protected $guarded = ['id'];

    protected $searchable = ['title'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('services.status_inactive');
                break;
            case 3:
                $label = __('services.status_deleted');
                break;
            default:
                $label = __('services.status_active');
                break;
        }

        return $label;
    }
}
