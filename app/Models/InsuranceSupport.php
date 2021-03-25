<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceSupport extends Model
{
    use HasFactory;

    protected $guarded;

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
