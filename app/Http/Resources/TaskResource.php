<?php

namespace App\Http\Resources;

use App\Device;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tmp_custom_reason = !is_array($this->custom_reason)?[]:$this->custom_reason;

        return [
            'id' => $this->id,
            'boundary_id' => $this->boundary_id,
            'device_id' => $this->device_id,
            'malfunction_id' => $this->malfunction_id,
            'user_id' => $this->user_id,
            'responsible_id' => $this->responsible_id,
            'started_at' => $this->started_at,
            'executed_at' => $this->executed_at,
            'note' => $this->note,
            'notes' => $this->notes,
            'report' => new ReportResource($this->report),
            'report_id' => $this->report_id,

            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'custom_reason' => $tmp_custom_reason,
            // связи
            'device' => Device::withTrashed()->find($this->device_id),
            'boundary' => $this->boundary,
            'malfunction' => $this->malfunction
        ];
    }
}
