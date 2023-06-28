<?php

namespace App\Http\Requests;

use App\Constants\FormConstant;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TempTeamUserFormRequest extends FormRequest
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
                'max:50'
            ],
            'teamLogo' => [
                'bail',
                'required',
                'max:2048',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'teamUrl' => [
                'nullable',
                'bail',
                'url',
                'max:255'
            ],
            'prefecture' => [
                'bail',
                'required',
                Rule::in(array_keys(FormConstant::PREFECTURES)),
            ],
            'address' => [
                'bail',
                'required',
                'max:50'
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
                function ($attribute, $value, $fail) {
                    $activeUser = User::getByEmail($value);
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
