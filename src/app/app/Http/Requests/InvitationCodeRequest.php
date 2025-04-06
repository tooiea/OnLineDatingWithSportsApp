<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvitationCodeRequest extends FormRequest
{
    protected $redirectRoute = 'temp_register.team.join.invalid';

    /**
     * URLの招待コードをマージ
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge(['invitation_code' => $this->route('invitation_code')]);
    }

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
            'invitation_code' => [
                'bail',
                'required',
                'string',
                'exist_team_code',
            ],
        ];
    }
}
