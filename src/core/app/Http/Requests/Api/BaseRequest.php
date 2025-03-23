<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * バリデーションエラーの時のレスポンスを定義
     *
     * @param  Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json(
            [
                'status' => 400,
                'message' => $this->getErrorMsg($validator->errors()),
                'content' => []
            ], 400
        );
        throw new HttpResponseException($response);
    }

    /**
     * エラーメッセージをカラムごとに取得する
     *
     * @param  object $errors
     * @return array
     */
    private function getErrorMsg($errors)
    {
        $errorMsg = [];
        foreach ($errors->toArray() as $key => $error) {
            $errorMsg[$key] = $error[0];
        }
        return $errorMsg;
    }
}
