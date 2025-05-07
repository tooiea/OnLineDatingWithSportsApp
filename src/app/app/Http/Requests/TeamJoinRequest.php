<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class TeamJoinRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // 入力されたURLから、invitation_codeを取得
        if (preg_match('/\/temp_register\/team\/join\/([a-zA-Z0-9]+)/', $this->teamUrl, $matches)) {
            $this->merge(['invitation_code' => $matches[1]]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teamUrl' => [
                'bail',
                'required',
                'string',
                'regex:/^' . preg_quote(config('app.url'), '/') . '\/temp_register\/team\/join(\/[a-zA-Z0-9]+)?$/',
            ],
            'invitation_code' => [
                'bail',
                'nullable',
                'string',
                'exist_team_code',
            ],
        ];
    }
}
