<?php

namespace App\Listeners;

use App\Events\CacheSpecialist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CacheSpecialistAfterSave
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
     * @param CacheSpecialist $event
     * @return void
     */
    public function handle(CacheSpecialist $event)
    {
        $event->user->saveToCache();
    }
}
