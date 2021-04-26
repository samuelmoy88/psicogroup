<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unease extends Model
{
    use HasFactory, FormatDates, Sortable, Cachable;

    protected $guarded = ['id'];

    protected $table = 'uneasiness';

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class,
    ];

    public function users()
    {
        return $this->belongsToMany(
            Unease::class,
            'uneasiness_users',
            'uneasiness_id',
            'user_id'
        );
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('uneasiness.status_inactive');
                break;
            case 3:
                $label = __('uneasiness.status_deleted');
                break;
            default:
                $label = __('uneasiness.status_active');
                break;
        }

        return $label;
    }
}
