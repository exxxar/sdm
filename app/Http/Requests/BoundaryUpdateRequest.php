<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoundaryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'boundary_group_id' => [''],
            'region_id' => [''],
            'deleted_at' => [''],
            'speed_mode' => [''],
            'mobile' => ['required'],
            'movable' => ['required'],
            'lat' => ['nullable', 'numeric'],
            'lon' => ['nullable', 'numeric'],
            'is_active' => [''],
            'devices' => [''],
            'violations' => ['']
        ];
    }
}
