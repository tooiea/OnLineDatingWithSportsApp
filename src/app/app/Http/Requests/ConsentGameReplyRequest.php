<?php

namespace App\Http\Requests;

use App\Enums\ConsentStatusTypeEnum;
use App\Models\ConsentGame;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConsentGameReplyRequest extends ConsentGameIdRequest
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
                Rule::enum(ConsentStatusTypeEnum::class),
            ],
            'second_preferered_date' => [
                'required',
                Rule::enum(ConsentStatusTypeEnum::class),
            ],
            'third_preferered_date' => [
                'bail',
                'nullable',
                Rule::enum(ConsentStatusTypeEnum::class),
            ],
            'message' => [
                'nullable',
            ],
        ];
        return array_merge(parent::rules(), $rules);
    }
}
