<?php

namespace App\Http\Requests;

use App\Constants\CommonConstant;
use App\Constants\ErrorMessagesConstant;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

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
                    $tempUser = new TempUser();
                    $activeUser = $tempUser->checkExpiration($value);
                    if (empty($activeUser)) {
                        // トークン有効期限切れ
                        $fail(ErrorMessagesConstant::EXPIRED_TOKEN);
                    }
                },
                function ($attribute, $value, $fail) {
                    $user = new User();
                    $activedUser = $user->join('temp_users', 'users.email', '=', 'temp_users.email')
                        ->select(['users.is_enabled'])
                        ->first();

                     // 不正アクセス
                    if (is_null($activedUser)) {
                        $fail(ErrorMessagesConstant::NOT_VALID_TOKEN);
                    } // 本登録済み
                    elseif ($activedUser->is_enabled === CommonConstant::FLAG_ON) {
                        $fail(ErrorMessagesConstant::ALREADY_REGISTERED);
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
            'token.exists' => ErrorMessagesConstant::NOT_VALID_TOKEN,
        ];
    }
}
