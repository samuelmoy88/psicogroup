<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressAccessibility extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function addresses()
    {
        return $this->belongsToMany(
            Address::class,
            'addresses_address_accessibilities',
            );
    }
}
