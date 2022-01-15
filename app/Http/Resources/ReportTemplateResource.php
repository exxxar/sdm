<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportTemplateResource extends JsonResource
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
            'parameter' => $this->parameter,
            'report_of' => $this->report_of,
            'recipients' => $this->recipients,
            'object' => $this->object,
            'important' => $this->important,
            'mailing' => $this->mailing,
        ];
    }
}
