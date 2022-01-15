<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoundaryScheduleStoreRequest extends FormRequest
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
            "type"=>"required",
            "start_at"=>"required",
            "boundary_id"=>"required",
            "address"=>"required",
            "end_at"=>"required",
            "is_installed"=>"required",
        ];
    }
}
