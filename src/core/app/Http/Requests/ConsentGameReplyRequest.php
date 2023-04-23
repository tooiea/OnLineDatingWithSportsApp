<?php

namespace App\Http\Requests;

use App\Constants\FormConstant;
use App\Models\ConsentGame;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ConsentGameReplyRequest extends FormRequest
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
                Rule::in(array_keys(FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT)),
            ],
            'second_preferered_date' => [
                'required',
                Rule::in(array_keys(FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT)),
            ],
            'third_preferered_date' => [
                'bail',
                'nullable',
                Rule::in(array_keys(FormConstant::CONSENT_REPLY_FORM_VALUE_TEXT)),
                function ($attribute, $value, $fail) {
                    $consent_game_id = $this->session()->get('consent_game_id');
                    $consent = ConsentGame::where('id', $consent_game_id)->first();

                    if (empty($consent->third_preferered_date)) {
                        $fail;
                    }
                }
            ],
            'message' => [
                'nullable',
            ],
        ];
    }
}
