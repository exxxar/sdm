<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'boundary_id' => [''],
            'device_id' => ['required'],
            'malfunction_id' => ['required'],
            'user_id' => [''],
            'responsible_id' => ['required'],
            'started_at' => [''],
            'executed_at' => [''],
            'note' => [''],
            'status' => [''],
            'deleted_at' => [''],
            'custom_reason' => ['max:255']
        ];
    }
}
