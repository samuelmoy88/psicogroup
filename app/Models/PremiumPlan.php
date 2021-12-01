<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Money;

class PremiumPlan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'payment_mode', 'price'];

    protected $casts = [
        'price' => Money::class
    ];

    public function features()
    {
        return $this->hasMany(PremiumPlanFeatures::class, 'premium_id', 'id');
    }
}
