<?php

namespace App\Listeners;

use App\Events\CacheEntity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheEntities
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CacheEntity $event
     * @return void
     */
    public function handle(CacheEntity $event)
    {
        $event->model->cache();
    }
}
