<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class InvitationUrlRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'teamUrl' => [
                'bail',
                'required',
                'exists:App\Models\Team,invitation_code',
            ],
            'teamUrlHost' => [
                function ($attribute, $value, $fail) {
                    // .envの環境ファイルで設定されたAPP_URLと一致するかを比較
                    if ($value === config('app.url')) {
                        return true;
                    }
                    return $fail(__('validation.exists'));
                }
            ],
        ];
    }

    /**
     * 入力されたURLを招待コードだけ抜き取る
     *
     * @return array
     */
    public function validationData()
    {
        $values = $this->all();

        // 入力があれば
        if (!empty($values['teamUrl'])) {
            $teamUrl = parse_url($values['teamUrl']);
            $path = str_replace('/tmp/register/join/', '', $teamUrl['path']);
            $values['teamUrl'] = $path;
        }

        return $values;
    }

    /**
     * 入力されたURLがアプリケーションで対応したスキーマとホストであるかをチェックするためマージ
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $values = $this->all();
        if (!empty($values['teamUrl'])) {
            $teamUrl = parse_url($values['teamUrl']);
            $invitationCode = str_replace('/tmp/register/join/', '', $teamUrl['path']);

            // 入力値としてセットしなおす
            $this->merge(['teamUrl' =>  $invitationCode]);
            $this->merge(['teamUrlHost' =>  $teamUrl['scheme'] . '://' . $teamUrl['host']]);
        }
    }
}
