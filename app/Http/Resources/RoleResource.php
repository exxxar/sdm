<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $tmp_permissions = [];

        foreach ($this->permissions as $permission)
            array_push($tmp_permissions, [
                "id"=>$permission->id,
                "name"=>$permission->name
            ]);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => $tmp_permissions,
        ];
    }
}
