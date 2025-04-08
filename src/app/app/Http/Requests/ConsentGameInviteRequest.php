<?php

namespace App\Http\Requests;

use App\Models\ConsentGame;
use Illuminate\Foundation\Http\FormRequest;

class ConsentGameInviteRequest extends ConsentGameTeamIdRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
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

        return array_merge($rules, parent::rules());
    }
}
