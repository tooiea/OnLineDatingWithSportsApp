<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TempUserFormRequest extends FormRequest
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
     * 継承ルールに追加
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'bail',
                'required',
                'max:20'
            ],
            'email' => [
                'bail',
                'required',
                'email:rfc,strict',
                function ($attribute, $value, $fail) {
                    $userModel = new User();
                    $activeUser = $userModel->getByEmail($value);
                    if ($activeUser) {
                        $fail(__('validation.unique'));
                    }
                },
            ],
            'password' => [
                'bail',
                'required',
                'regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,}+\z/',
            ],
            'password2' => [
                'bail',
                'required',
                'same:password'
            ],
        ];
    }
}
