<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'period' => $this->period,
            'regularity' => $this->regularity,
            'parameter' => $this->parameter,
            'report_of' => $this->report_of,
            'recipients' => $this->recipients,
            'object' => $this->object,
            'automatic' => $this->automatic,
            'important' => $this->important,
            'mailing' => $this->mailing,
            'is_hidden' => $this->is_hidden,
            'is_active' => $this->is_active,
            'start_period_date' => $this->start_period_date,
            'end_period_date' => $this->end_period_date,
        ];
    }
}
