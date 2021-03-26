<?php

namespace App\Models;

use App\Traits\FormatDates;
use App\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes, FormatDates, Sortable;

    protected $guarded = ['id'];

    public function addresses()
    {
        return $this->belongsToMany(
            Address::class,
            'addresses_payment_methods',
            );
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->attributes['status']) {
            case 2:
                $label = __('payment-methods.status_inactive');
                break;
            case 3:
                $label = __('payment-methods.status_deleted');
                break;
            default:
                $label = __('payment-methods.status_active');
                break;
        }

        return $label;
    }
}
