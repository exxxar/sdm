<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ErrorTaskEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $properties;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($properties)
    {
        $this->properties = (object)[
            "device_id" => $properties->device_id,
            "malfunction_id" => $properties->malfunction_id ?? 6,
            "boundary_id" => $properties->boundary_id ?? null,
            "user_id" => $properties->user_id ?? 5,
            "responsible_id" => $properties->responsible_id ?? 5,
            "started_at" => $properties->started_at ?? null,
            "executed_at" => $properties->executed_at ?? null,
            "note" => $properties->note ?? null,
            "notes" => $properties->notes ?? null,
            "deleted_at" => $properties->deleted_at ?? null,
            "status" => $properties->status ?? "Актуальные",
            "custom_reason" => $properties->custom_reason ?? null,
            "report_id" => $properties->report_id ?? null,
        ];
    }
}
