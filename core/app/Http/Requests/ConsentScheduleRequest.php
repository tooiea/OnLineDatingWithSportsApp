<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsentScheduleRequest extends FormRequest
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
            'first_preferered_date' => [
                'required',
                'date',
                'different:second_preferered_date',
                'different:third_preferered_date',
                'after:today',
            ],
            'second_preferered_date' => [
                'required',
                'date',
                'different:third_preferered_date',
                'after:today',
            ],
            'third_preferered_date' => [
                'nullable',
                'date',
                'after:today',
            ],
            'message' => [
                'nullable',
            ],
        ];
    }
}
