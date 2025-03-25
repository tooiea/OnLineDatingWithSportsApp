<?php

namespace App\Http\Requests;

use App\Models\TempUser;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class UserTokenRequest extends FormRequest
{
    protected $redirectRoute = 'user.failed';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * URLのトークンセット
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['token' => $this->route('token')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'token' => [
                'bail',
                'exists:App\Models\TempUser,token',
                function ($attribute, $value, $fail) {
                    $tempUser = TempUser::where([
                        ['expiration_date','>=', CarbonImmutable::now()],
                        ['token', '=', $value],
                    ])->first();

                    // トークン有効期限切れ
                    if (is_null($tempUser)) {
                        return $fail(__('validation.custom.token.expired'));
                    }

                    $registeredUser = User::where('email', $tempUser->email)->first();

                    // 本登録済み
                    if (! empty($registeredUser)) {
                        $fail(__('validation.custom.token.registered'));
                    }
                },
            ],
        ];
    }
}
