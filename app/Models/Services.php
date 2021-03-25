<?php

namespace App\Models;

use App\Traits\FormatDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory, SoftDeletes, FormatDates;

    protected $guarded = ['id'];

    public function addresses()
    {
        return $this->belongsToMany(
            Address::class,
            'addresses_profile_services',
            'profile_service_id',
            'address_id'
            );
    }

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
