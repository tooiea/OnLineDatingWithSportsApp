<?php

namespace App\Http\Requests;

use App\Models\TeamAlbum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
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
            'teamName' => [
                'bail',
                'required',
                'max:50'
            ],
            'teamUrl' => [
                'bail',
                'nullable',
                'string',
                'url',
            ],
            'imagePath' => [
                'bail',
                'max:2048',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'deleteAlbum.*' => [
                'bail',
                'nullable',
                'integer',
                // TODO 画像が存在するかチェック
                'exist_album_id',
            ],
            'teamAlbum.*' => [
                'bail',
                'nullable',
                'max:1024',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'teamAlbumTotal' => [
                // TODO 削除数と登録数を比較して5枚を超えないかをチェック
                'imageQtyWithinMax'
            ],
        ];
    }

    /**
     * バリデーション前にリクエストにセット
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $teamAlbumTotal = 0;
        // 各変数で入力された画像の枚数を取得する
        // teamAlbumは追加(加算)、deleteAlbumは削除(減算)
        $teamAlbumTotal += count($this->input['teamAlbum']);
        $teamAlbumTotal -= count($this->input['deleteAlbum']);
        Log::info($teamAlbumTotal);
        $this->merge(['teamAlbumTotal' => $teamAlbumTotal]);
    }
}
