<?php


namespace App\Traits;


trait ScopeActives
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
