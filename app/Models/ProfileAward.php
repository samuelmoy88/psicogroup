<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProfileAward extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function specialist()
    {
        return $this->belongsTo(SpecialistProfile::class);
    }

    public function getFullLabelAttribute()
    {
        if (!$this->title) return '';

        $label = $this->title;

        if ($this->year) {
            $label .= " ({$this->year})";
        }

        return $label;
    }
}
