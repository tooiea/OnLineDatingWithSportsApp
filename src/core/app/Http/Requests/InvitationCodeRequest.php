<?php

namespace App\Http\Requests;

use App\Constants\ErrorMessagesConstant;
use Illuminate\Foundation\Http\FormRequest;

class InvitationCodeRequest extends FormRequest
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

    protected $redirectRoute = 'tempUsers.failed';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'invitation_code' => [
                'bail',
                'required',
                'exists:App\Models\Team,invitation_code'
            ],
        ];
    }

    /**
     * URLに入力された招待コードをマージ
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $invitationCode = $this->route('invitation_code');
        $this->merge([
            'invitation_code' => $invitationCode,
        ]);
    }
}
