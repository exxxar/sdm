<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceUpdateRequest extends FormRequest
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
            'serial' => ['required', 'string', 'max:255'],
            'ip' => ['required', 'string', 'max:255'],
            'device_group_id' => [''],
            'device_boundary_id' => [''],
            'lat' => ['nullable', 'numeric'],
            'lon' => ['nullable', 'numeric'],
            'device_type_id' => ['required', 'exists:device_types,id'],
            'region_id' => [''],
            'connection' => ['max:255'],
            'port' => ['max:255'],
            'login' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'secret' => ['required', 'string', 'max:255'],
            'installation_date' => [''],
            'withdrawal_date' => [''],
            'properties' => ['json'],
            'mobile' => ['required'],
            'movable' => ['required'],
            'is_active' => [''],
        ];
    }
}
