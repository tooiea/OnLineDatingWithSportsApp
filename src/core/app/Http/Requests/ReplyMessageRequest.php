<?php

namespace App\Http\Requests;

use App\Models\ConsentGame;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

class ReplyMessageRequest extends FormRequest
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
            'consent_game_id' => [
                'bail',
                'required',
                function ($attribute, $value, $fail) {
                    $decryptedId = Crypt::decryptString($value);
                    $consentGame = ConsentGame::find($decryptedId);

                    // 存在しない試合招待id
                    if (is_null($consentGame)) {
                        Log::alert(__('validation.exists'));
                        $fail(__('validation.exists'));
                    }
                }
            ],
            'message' => [
                'bail',
                'required',
                'string'
            ]
        ];
    }
}
