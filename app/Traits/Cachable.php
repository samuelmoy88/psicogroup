<?php


namespace App\Traits;


trait Cachable
{
    public function cache()
    {
        return cache()->store(config('cache.default'))->set(self::class, collect(self::toCache()->get()->toArray()), now()->addDays(5));
    }

    public function scopeToCache($query)
    {
        return $query->where('status', 1)->orderBy('order', 'asc');
    }
}
