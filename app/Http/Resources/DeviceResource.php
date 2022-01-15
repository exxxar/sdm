<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'serial' => $this->serial,
            'type' => $this->deviceType,
            'region' => $this->region,
            'group' => $this->group,
            'boundary' => $this->deviceBoundary,
            'location_title' =>$this->location->title??'' ,
            'ping' =>$this->ping ,
            'device_boundary_id' => $this->device_boundary_id,
            'is_active' => $this->is_active,
            'is_alive' => $this->is_alive,
            'mobile' => $this->mobile,
            'movable' => $this->movable,
            'device_type_id' => $this->device_type_id,
            'device_group_id' => $this->device_group_id,
            'deleted_at' => $this->deleted_at,
            'login' => $this->login,
            'password' => $this->password,
            'ip' => $this->ip,
            'connection' => $this->connection,
            'certificate' => $this->certificate
        ];
    }
}
