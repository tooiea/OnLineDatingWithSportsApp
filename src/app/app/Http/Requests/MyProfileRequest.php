<?php

namespace App\Http\Requests;

use App\Enums\SportAffiliationTypeEnum;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class MyProfileRequest extends FormRequest
{
    /**
     * ユーザ情報
     *
     * @var Team
     */
    private SportAffiliationTypeEnum $sport_affiliation_type;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * ユーザのチームをセット
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->sport_affiliation_type = User::with('teamMember.team')->find(Auth::id())->teamMember->team->sport_affiliation_type;
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
            'position' => [
                'bail',
                'nullable',
                'integer',
                Rule::enum($this->sport_affiliation_type->positionClass())
            ],
            'handedness' => [
                'bail',
                'nullable',
                'integer',
                Rule::enum($this->sport_affiliation_type->handednessClass())
            ],
            'image' => [
                'bail',
                'nullable',
                'max:3072',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'deleteImage' => [
                'bail',
                'required',
                'boolean'
            ]
        ];
    }
}
