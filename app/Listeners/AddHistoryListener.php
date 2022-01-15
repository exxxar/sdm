<?php

namespace App\Listeners;

use App\Events\AddHistoryEvent;
use App\History;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddHistoryListener
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
    public function handle(AddHistoryEvent $event)
    {
        if (is_null($event))
            return;

        History::create([
            'user_id'=>$event->user_id,
            'type'=>$event->type,
            'object_id'=>$event->object_id,
            'action'=>$event->action,
        ]);
    }
}
