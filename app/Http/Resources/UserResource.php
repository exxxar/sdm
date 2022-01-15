<?php

namespace App\Http\Resources;

use App\DeviceGroup;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'history' => new HistoryCollection($this->history),
            'device_groups' =>new DeviceCollection($this->device_groups)
        ];
    }
}
