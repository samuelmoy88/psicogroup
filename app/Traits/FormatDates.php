<?php


namespace App\Traits;


trait FormatDates
{
    public function getCreatedReadableAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['created_at']));
    }

    public function getUpdatedReadableAttribute()
    {
        return date('d/m/Y', strtotime($this->attributes['updated_at']));
    }
}
