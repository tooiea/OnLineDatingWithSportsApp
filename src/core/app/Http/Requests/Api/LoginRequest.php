<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Auth\LoginRequest as AuthLoginRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class LoginRequest extends AuthLoginRequest
{
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
