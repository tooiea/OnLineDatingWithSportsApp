<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Enums\Prefecture;
use App\Enums\SportAffiliationTypeEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TempTeamRegisterRequest extends FormRequest
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
        return [
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
            'sportAffiliationType' => [
                'bail',
                'required',
                Rule::enum(SportAffiliationTypeEnum::class)
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
                Rule::enum(Prefecture::class),
            ],
            'address' => [
                'bail',
                'required',
                'max:50'
            ],
        ];
    }
}
