<?php

namespace App\Listeners;

use App\Events\CacheUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheUserAfterSave
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
     * @param CacheUser $event
     * @return void
     */
    public function handle(CacheUser $event)
    {
        $event->user->saveToCache();
    }
}
