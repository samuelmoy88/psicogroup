<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePublication extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function specialists()
    {
        return $this->belongsTo(SpecialistProfile::class);
    }

    public function getFullLabelAttribute()
    {
        if (!$this->title) return '';

        $label = '';

        if ($this->year) {
            $label = "({$this->year})";
        }

        $label .= " " . $this->title;

        if ($this->url && filter_var($this->url, FILTER_VALIDATE_URL)) {
            $label .= " | <a class='text-blue-500 underline cursor-pointer' href='{$this->url}' target='_blank'  rel='noreferrer noopener'>enlace</a>";
        }

        return $label;
    }
}
