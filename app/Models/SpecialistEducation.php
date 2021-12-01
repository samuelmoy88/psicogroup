<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialistEducation extends Model
{
    use HasFactory;

    const LEVEL_BACHELOR = 1;
    const LEVEL_COLLEGE = 2;
    const LEVEL_MASTERS = 3;
    const LEVEL_DOCTORATE = 4;
    const LEVEL_PHD = 5;

    protected $guarded = ['id'];

    public function getLevelLabelAttribute()
    {
        return $this->level ? __('education.level_' . $this->level) : '';
    }

    public function getEducationLevels()
    {
        return EducationDegree::orderBy('order')->get();
    }

    public function specialist()
    {
        return $this->belongsTo(SpecialistProfile::class);
    }

    public function degrees()
    {
        return $this->belongsTo(EducationDegree::class, 'level', 'id');
    }

    public function getFullLabelAttribute()
    {
        if (!$this->title) return '';

        $title = $this->title;

        if ($this->institution) {
            $title .= ' en ' . $this->institution;
        }

        if ($this->end) {
            $title .= " ({$this->end})";
        }

        return $title;
    }
}
