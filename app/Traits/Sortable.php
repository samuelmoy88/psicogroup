<?php


namespace App\Traits;


Trait Sortable
{
    public static function sort($id, $order)
    {
        return self::where('id', $id)->update(['order' => $order]);
    }
}
