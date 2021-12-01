<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileLanguage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function specialist()
    {
        return $this->hasMany(SpecialistProfile::class);
    }

    public function getLanguageLabelAttribute()
    {
        if (!$this->language) return "";

        return ucfirst(languagesList()[$this->language]);
    }

    public function getLabelAttribute()
    {
        if (!$this->language && !isset(languagesList()[$this->language])) return '';

        return languagesList()[$this->language];
    }
}
