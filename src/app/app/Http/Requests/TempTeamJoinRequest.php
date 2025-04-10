<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class TempTeamJoinRequest extends InvitationCodeRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'nickname' => [
                'bail',
                'required',
                'max:20'
            ],
            'email' => [
                'bail',
                'required',
                'email:rfc,strict',
                function ($attribute, $value, $fail) {
                    $activeUser = User::where($attribute, $value)->first();
                    if ($activeUser) {
                        $fail(__('validation.unique'));
                    }
                },
            ],
            'password' => [
                'bail',
                'required',
                'regex:/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)(?=.*?[@#$\-_])[a-zA-Z\d@#$\-_]{8,}\z/',
            ],
            'password2' => [
                'bail',
                'required',
                'same:password'
            ],
        ];
        return array_merge(parent::rules(), $rules);
    }
}
