<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportUpdateRequest extends FormRequest
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
            'period' => ['required'],
            'regularity' => [''],
            'parameter' => ['required'],
            'report_of' => ['required'],
            'recipients' => [''],
            'object' => ['required'],
            'automatic' => [''],
            'important' => [''],
            'mailing' => [''],
            'is_hidden' => [''],
            'is_active' => [''],
            'start_period_date' => [''],
            'end_period_date' => [''],
        ];
    }
}
