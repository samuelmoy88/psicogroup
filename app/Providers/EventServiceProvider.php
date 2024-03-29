<?php

namespace App\Providers;

use App\Events\CacheEntity;
use App\Events\CacheUser;
use App\Events\UpdatingSpecialist;
use App\Listeners\CacheEntities;
use App\Listeners\CacheUserAfterSave;
use App\Listeners\TrackSpecialistChanges;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UpdatingSpecialist::class => [
            TrackSpecialistChanges::class
        ],
        CacheUser::class => [
            CacheUserAfterSave::class
        ],
        CacheEntity::class => [
            CacheEntities::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
