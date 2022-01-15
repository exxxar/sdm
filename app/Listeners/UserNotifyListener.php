<?php

namespace App\Listeners;

use App\Events\UserNotifyEvent;
use App\Mail\NotifyMail;
use App\Mail\ReportMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserNotifyListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(UserNotifyEvent $event)
    {
        if (is_null($event))
            return;

        try {
            Mail::to($event->email)->send(new NotifyMail($event->message));
        }catch (\Exception $e){

        }


    }
}
