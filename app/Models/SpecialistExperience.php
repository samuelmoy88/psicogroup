<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SpecialistExperience extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function specialist()
    {
        return $this->hasMany(SpecialistProfile::class);
    }

    public function getStartYearFormattedAttribute()
    {
        if (!$this->start_year) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->start_year);
        return $date->format('Y');
    }

    public function getStartMonthFormattedAttribute()
    {
        if (!$this->start_year) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->start_year);
        return $date->format('m');
    }

    public function getEndYearFormattedAttribute()
    {
        if (!$this->end_year) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->end_year);
        return $date->format('Y');
    }

    public function getEndMonthFormattedAttribute()
    {
        if (!$this->end_year) return '';
        $date = Carbon::createFromFormat('Y-m-d', $this->end_year);
        return $date->format('m');
    }

    public function getFullLabelAttribute()
    {
        if (!$this->job_title) return '';

        $label = $this->job_title;

        if ($this->company_name) {
            $label .= " " . strtolower(trans('common.in')) . " {$this->company_name}";
        }

        if ($this->location) {
            $label .= " | " . $this->location;
        }

        if ($this->start_year && $this->current_job) {
            $label .= " (".monthsOfTheYear()[$this->startMonthFormatted]." {$this->startYearFormatted} - " . trans('common.job_now') . ")";
        } elseif ($this->start_year && $this->end_year) {
            $label .= " (".monthsOfTheYear()[$this->startMonthFormatted]." {$this->startYearFormatted} - ".monthsOfTheYear()[$this->endMonthFormatted]." {$this->endYearFormatted})";
        }

        return $label;
    }
}
