<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumPlanFeatures extends Model
{
    use HasFactory;


    protected $fillable = ['title', 'description', 'order'];

    public function plan()
    {
        return $this->belongsTo(PremiumPlan::class, 'id', 'premium_id');
    }
}
