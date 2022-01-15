<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BoundaryScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $date = Carbon::parse($this->start_at)->format("d.m.Y");
        $start_time =  Carbon::parse($this->start_at)->format("H:i");
        $end_time =  Carbon::parse($this->end_at)->format("H:i");
        return [
            "id"=>$this->id,
            "type"=>$this->type,
            "start_time"=>$start_time,
            "end_time"=>$end_time,
            "date"=>$date,
            "boundary"=>new BoundaryResource($this->boundary),
            "is_installed"=>$this->is_installed,
            "address"=>$this->address,
        ];
    }
}
