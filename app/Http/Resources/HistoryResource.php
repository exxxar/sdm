<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'type' => $this->type,
            'object_id' => $this->object_id,
            'action' => $this->action,
            'created_at' => $this->created_at,
            'user' => $this->user,
            'object' => $this->getObjectAttribute()
        ];
    }
}
