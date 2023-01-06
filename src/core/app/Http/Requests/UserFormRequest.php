<?php

namespace App\Http\Requests;

use App\Constants\ErrorMessagesConstant;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
        $rules = [
            'name1' => [
                'bail',
                'required',
                'max:20'
            ],
            'name2' => [
                'bail',
                'required',
                'max:20'
            ],
            'ruby1' => [
                'bail',
                'required',
                'max:20',
                'regex:/^[ァ-ヾ]+$/u'
            ],
            'ruby2' => [
                'bail',
                'required',
                'max:20',
                'regex:/^[ァ-ヾ]+$/u'
            ],
            'birthday' => [
                'bail',
                'required',
                'date',
            ],
            'email' => [
                'bail',
                'required',
                'email:rfc,strict',
                function ($attribute, $value, $fail) {
                    $userModel = new User();
                    $activeUser = $userModel->getByEmail($value);
                    if (!empty($activeUser)) {
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
                'same:password',
            ],
            'invitationCode' => [
                'nullable',
                'bail',
                'exists:App\Models\Team,invitation_code'
            ],
        ];
        return $rules;
    }

    /**
     * メッセージセット
     *
     * @return array
     */
    public function messages()
    {
        $messages = [
            'name1.required' => ErrorMessagesConstant::USER_FORM['name1.required'],
            'name1.max' => ErrorMessagesConstant::USER_FORM['name1.max'],
            'name2.required' => ErrorMessagesConstant::USER_FORM['name2.required'],
            'name2.max' => ErrorMessagesConstant::USER_FORM['name2.max'],
            'ruby1.required' => ErrorMessagesConstant::USER_FORM['ruby1.required'],
            'ruby1.max' => ErrorMessagesConstant::USER_FORM['ruby1.max'],
            'ruby1.regex' => ErrorMessagesConstant::USER_FORM['ruby1.regex'],
            'ruby2.required' => ErrorMessagesConstant::USER_FORM['ruby2.required'],
            'ruby2.max' => ErrorMessagesConstant::USER_FORM['ruby2.max'],
            'ruby2.regex' => ErrorMessagesConstant::USER_FORM['ruby2.regex'],
            'birthday.required' => ErrorMessagesConstant::USER_FORM['birthday.required'],
            'birthday.date' => ErrorMessagesConstant::USER_FORM['birthday.date'],
            'email.required' => ErrorMessagesConstant::USER_FORM['email.required'],
            'email.regex' => ErrorMessagesConstant::USER_FORM['email.regex'],
            'password.required' => ErrorMessagesConstant::USER_FORM['password.required'],
            'password.regex' => ErrorMessagesConstant::USER_FORM['password.regex'],
            'password2.required' => ErrorMessagesConstant::USER_FORM['password2.required'],
            'password2.same' => ErrorMessagesConstant::USER_FORM['password2.same'],
            'invitationCode.exists' => ErrorMessagesConstant::USER_FORM['invitationCode.exists'],
        ];
        return $messages;
    }
}
