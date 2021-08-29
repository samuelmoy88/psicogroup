<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserDeletion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function generateCode()
    {
        $this->verification_code = rand(100000, 999999);
        $this->valid_until = Carbon::now()->addMinutes(10);
    }
}
