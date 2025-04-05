<?php

namespace App\Http\Requests;

use App\Enums\Prefecture;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MyTeamEditRequest extends FormRequest
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
            'teamName' => [
                'bail',
                'required',
                'max:30'
            ],
            'prefecture' => [
                'bail',
                'nullable',
                Rule::enum(Prefecture::class),
            ],
            'address' => [
                'bail',
                'nullable',
                'string',
                'max:100',
            ],
            'favoriteFacility' => [
                'bail',
                'nullable',
                'string',
                'max:30',
            ],
            'teamUrl' => [
                'bail',
                'nullable',
                'string',
                'url',
            ],
            'teamMainImage' => [
                'bail',
                'nullable',
                'max:2048',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'albums.*' => [
                'bail',
                'nullable',
                'max_in_album:5',
            ],
            'albums.*.id.*' => [
                'bail',
                'nullable',
                'uuid',
            ],
            'albums.*.name' => [
                'bail',
                'required',
                'max:30',
            ],
            'albums.*.addImages.*' => [
                'bail',
                'nullable',
                'max:1024',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'albums.*.deleteImages' => [
                'bail',
                'nullable',
                'array'
            ],
            'albums.*.deleteImages.*' => [
                'bail',
                'nullable',
                'uuid',
                'exist_team_album',
            ],
        ];
    }
}
