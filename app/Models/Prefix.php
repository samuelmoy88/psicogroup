<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function specialists()
    {
        return $this->hasMany(SpecialistProfile::class);
    }
}
