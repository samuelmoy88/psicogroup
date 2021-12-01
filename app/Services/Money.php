<?php


namespace App\Services;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Money implements CastsAttributes
{
    public function set($model, string $key, $value, array $attributes)
    {
        return $value * 100;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        return $value / 100;
    }
}
