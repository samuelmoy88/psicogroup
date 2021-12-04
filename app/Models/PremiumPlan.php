<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Money;

class PremiumPlan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'payment_mode', 'payment_mode', 'price', 'currency', 'discount', 'discount_until', 'order'];

    protected $casts = [
        'price' => Money::class
    ];

    public function features()
    {
        return $this->hasMany(PremiumPlanFeatures::class, 'premium_id', 'id');
    }
}
