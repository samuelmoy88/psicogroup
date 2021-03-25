<?php

namespace App\Listeners;

use App\Events\UpdatingSpecialist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TrackSpecialistChanges
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
     * @param  UpdatingSpecialist  $event
     * @return void
     */
    public function handle(UpdatingSpecialist $event)
    {
        $event->model->trackChanges();
    }
}
