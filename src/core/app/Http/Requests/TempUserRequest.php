<?php

namespace App\Http\Requests;

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
        return [
            'email' => [
                'bail',
                'required',
                'email:strict',
                'unique:App\Models\TempUser,email'
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスを正しく入力してください',
            'email.unique' => '入力されたメールアドレスはすでに登録済みです'
        ];
    }
}
