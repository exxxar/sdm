<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AddHistoryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user_id;
    public $type;
    public $object_id;
    public $action;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user_id,$type,$object_id,$action)
    {
        $this->user_id =$user_id;
        $this->type = $type;
        $this->object_id = $object_id;
        $this->action = $action;
    }

}
