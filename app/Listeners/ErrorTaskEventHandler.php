<?php

namespace App\Listeners;

use App\Events\ErrorTaskEvent;
use App\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ErrorTaskEventHandler
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
     * @param  ErrorTaskEvent  $event
     * @return void
     */
    public function handle(ErrorTaskEvent $event)
    {
        if (is_null($event))
            return;

        $task = Task::where('device_id', $event->properties->device_id)
                    ->where('malfunction_id', $event->properties->malfunction_id)
                    ->where('status', 'Актуальные')->first();

        if ($task)
            return;

        Task::create([
            'boundary_id'=>$event->properties->boundary_id,
            'device_id'=>$event->properties->device_id,
            'malfunction_id'=>$event->properties->malfunction_id,
            'user_id'=>$event->properties->user_id,
            'responsible_id'=>$event->properties->responsible_id,
            'started_at'=>$event->properties->started_at,
            'executed_at'=>$event->properties->executed_at,
            'note'=>$event->properties->note,
            'notes'=>$event->properties->notes,
            'deleted_at'=>$event->properties->deleted_at,
            'status'=>$event->properties->status,
            'custom_reason'=>$event->properties->custom_reason,
            'report_id'=>$event->properties->report_id,
        ]);
    }
}
