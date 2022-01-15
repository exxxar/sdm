<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceParametersHistoryResource extends JsonResource
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
            'device_id' => $this->device_id,
            'violations' => $this->violations,
            'passages' => $this->passages,
            'status' => $this->status,
            'ping' => $this->ping,
            'voltage' => $this->voltage,
        ];
    }
}
