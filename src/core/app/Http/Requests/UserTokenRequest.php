<?php

namespace App\Http\Requests;

use App\Constants\ErrorMessagesConstant;
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
                'exists:App\Models\TempUser,token'
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
            'token.exists' => ErrorMessagesConstant::TEMPLATE_LOST_TOKEN,
        ];
    }
}
