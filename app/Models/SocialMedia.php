<?php

namespace App\Models;

use App\Events\CacheEntity;
use App\Traits\Cachable;
use App\Traits\FormatDates;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory, FormatDates, Cachable, Sortable;

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'saved' => CacheEntity::class
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('url', 'username')
            ->withTimestamps();
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('social-media.status_inactive');
                break;
            case 3:
                $label = __('social-media.status_deleted');
                break;
            default:
                $label = __('social-media.status_active');
                break;
        }

        return $label;
    }
}
