<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TeamAlbumRequest extends FormRequest
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
                'string',
                'url',
            ],
            'teamLogo' => [
                'bail',
                'required',
                'max:2048',
                'file',
                'image',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'deleteAlbum.*' => [
                'bail',
                'integer',
                // TODO 画像が存在するかチェック
            ],
            'teamAlbum.*' => [
                'bail',
                'required',
                'max:2048',
                'file',
                'image',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
        ];
    }
}
