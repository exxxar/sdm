<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoundaryResource extends JsonResource
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
            'title' => $this->title,
            'boundary_group_id' => $this->boundary_group_id,
            'group' => new BoundaryGroupResource($this->boundary_group),
            'passages'=>$this->passages,
            'violations'=>$this->violations,
            'region_id' => $this->region_id,
            'region' => $this->region,
            'devices' => $this->devices,
            'devices_count' => $this->devices->count(),
            'is_active' => $this->is_active,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'uninstall_date' => $this->uninstall_date,
            'install_date' => $this->install_date,
            'mobile' => $this->mobile,
            'movable' => $this->movable,
        ];
    }
}
