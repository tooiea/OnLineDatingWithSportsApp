<?php

namespace App\Http\Requests;

use App\Models\TempUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserTokenRequest extends FormRequest
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

    protected $redirectRoute = 'users.failed';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => [
                'bail',
                'exists:App\Models\TempUser,token',
                function ($attribute, $value, $fail) {
                    $tempUser = TempUser::checkExpiration($value);

                    // トークン有効期限切れ
                    if (is_null($tempUser)) {
                        return $fail(__('validation.custom.token.expired'));
                    }

                    $registeredUser = User::where('email', '=', $tempUser->email)->first();

                    // 本登録済み
                    if (!is_null($registeredUser)) {
                        $fail(__('validation.custom.token.registered'));
                    }
                },
            ],
        ];
    }

    /**
     * URLのトークンをバリデーション用でセット
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $token = $this->route('token');
        $this->merge([
            'token' => $token
        ]);
    }

    /**
     * メッセージセット
     *
     * @return void
     */
    public function messages()
    {
        return [
            'token.exists' => __('validation.custom.token.notvalid'),
        ];
    }
}
