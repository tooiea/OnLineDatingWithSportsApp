<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class ConsentGameIdRequest extends FormRequest
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
                'required',
                'exists:App\Models\ConsentGame,id'
            ],
        ];
    }

    /**
     * ルートパラメータを取得して復号化する
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // 取得したidを復号化
        $consent_game_id = Crypt::decryptString($this->route('consent_game_id'));
        $this->merge([
            'consent_game_id' => $consent_game_id,
        ]);
    }
}
