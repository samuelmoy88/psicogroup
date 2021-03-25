<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistProfileServices extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'services_specialist_profiles';

    public function users()
    {
        return $this->belongs(
            SpecialistProfile::class,
            'specialist_profile_id'
        );
    }

    public function services()
    {
        return $this->belongsTo(
            Services::class,
            'service_id',
        );
    }
}
