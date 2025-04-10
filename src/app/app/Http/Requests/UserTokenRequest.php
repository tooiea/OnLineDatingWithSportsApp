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
                'exists:App\Models\Code,code',
                function ($attribute, $value, $fail) {
                    $tempUser = TempUser::whereRelation('code', function ($query) use ($value) {
                        // トークンの有効期限チェック
                        $query->where('expired_at', '>=', CarbonImmutable::now());
                        // トークンの存在チェック
                        $query->where('code', $value);
                        $query->where('is_used', false);
                    })->first();

                    // 有効なトークンでない場合
                    if (empty($tempUser)) {
                        return $fail(__('validation.custom.token.expired'));
                    }
                },
            ],
        ];
    }
}
