<?php

namespace App\Http\Requests;

use App\Constants\CommonConstant;
use App\Constants\ErrorMessagesConstant;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TempTeamUserRequest extends FormRequest
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
            'sportAffiliationType' => [
                'bail',
                'required',
                Rule::in(Arr::pluck(\App\Enums\SportAffiliationTypeEnum::cases(), 'value'))
            ],
            'teamName' => [
                'bail',
                'required',
                'max:255'
            ],
            'teamLogo' => [
                'bail',
                'required',
                'max:1024',
                'file',
                'image',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'teamUrl' => [
                'bail',
                'required',
                'url',
                'max:255'
            ],
            'prefecture' => [
                'bail',
                'required',
                Rule::in(array_keys(CommonConstant::PREFECTURES)),
            ],
            'address' => [
                'bail',
                'required',
                'max:255'
            ],
            'name' => [
                'bail',
                'required',
                'max:20'
            ],
            'email' => [
                'bail',
                'required',
                'email:rfc,strict',
                // TODO users.emailに存在しているかチェックに変更
                function ($attribute, $value, $fail) {
                    $userModel = new User();
                    $activeUser = $userModel->getByEmail($value);
                    if ($activeUser) {
                        $fail(ErrorMessagesConstant::USER_FORM['email.unique']);
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