<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SpecialistCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function specialist()
    {
        return $this->hasMany(SpecialistProfile::class);
    }

    public function getExpeditionYearFormattedAttribute()
    {
        if (!$this->expedition_date) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->expedition_date);
        return $date->format('Y');
    }

    public function getExpeditionMonthFormattedAttribute()
    {
        if (!$this->expedition_date) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->expedition_date);
        return $date->format('m');
    }

    public function getExpirationYearFormattedAttribute()
    {
        if (!$this->expiration_date) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->expiration_date);
        return $date->format('Y');
    }

    public function getExpirationMonthFormattedAttribute()
    {
        if (!$this->expiration_date) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->expiration_date);
        return $date->format('m');
    }

    public function getFullLabelAttribute()
    {
        if (!$this->name) return '';

        $label = $this->name;

        if ($this->company_name) {
            $label .= " " . strtolower(trans('common.in')) . " {$this->company_name}";
        }

        if ($this->location) {
            $label .= " | " . $this->location;
        }

        if ($this->expedition_date && !$this->expires) {
            $label .= " (".monthsOfTheYear()[$this->expeditionMonthFormatted]." {$this->expeditionYearFormatted})";
        } elseif ($this->expires && $this->expiration_date) {
            $label .= " (".monthsOfTheYear()[$this->expeditionMonthFormatted]." {$this->expeditionYearFormatted} - ".monthsOfTheYear()[$this->expirationMonthFormatted]." {$this->expirationYearFormatted})";
        }

        return $label;
    }
}
