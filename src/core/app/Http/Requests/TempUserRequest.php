<?php

namespace App\Http\Requests;

use App\Constants\ErrorMessagesConstant;
use Illuminate\Foundation\Http\FormRequest;

class TempUserRequest extends FormRequest
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
        // FIXME Usersテーブルへ登録する内容へ修正
        return [
            'email' => [
                'bail',
                'required',
                'email:strict',
                'unique:App\Models\User,email'
            ],
        ];
    }

    /**
     * メッセージセット
     *
     * @return void
     */
    public function messages()
    {
        // FIXME Usersテーブルへ登録する内容へ修正
        return [
            'email.required' => ErrorMessagesConstant::REQUEST_MESSAGE_TEMP_USER['email.required'],
            'email.email' => ErrorMessagesConstant::REQUEST_MESSAGE_TEMP_USER['email.email'],
            'email.unique' => ErrorMessagesConstant::REQUEST_MESSAGE_TEMP_USER['email.unique']
        ];
    }
}
