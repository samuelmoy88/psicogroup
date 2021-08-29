<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VerifyConsultation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function generateToken()
    {
        $this->token = rand(100000, 999999);
        $this->valid_until = Carbon::now()->addMinutes(10);
    }
}
