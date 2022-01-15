<?php

namespace App\Providers;

use App\Events\AddHistoryEvent;
use App\Events\ErrorTaskEvent;
use App\Events\UserNotifyEvent;
use App\Listeners\AddHistoryListener;
use App\Listeners\ErrorTaskEventHandler;
use App\Listeners\UserNotifyListener;
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

        UserNotifyEvent::class => [
            UserNotifyListener::class,
        ],

        AddHistoryEvent::class => [
            AddHistoryListener::class,
        ],

        ErrorTaskEvent::class => [
            ErrorTaskEventHandler::class,
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
