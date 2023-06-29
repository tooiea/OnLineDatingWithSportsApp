<?php

namespace App\Http\Requests;

use App\Models\TeamAlbum;
use App\Models\TeamMember;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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
                'nullable',
                'max:2048',
                'file',
                'image',
                'mimes:jpeg,jpg,png',
                'mimetypes:image/jpeg,image/jpg,image/png',
            ],
            'deleteAlbum' => [
                'bail',
                'nullable',
                'array',
                'exist_album_id',
            ],
            'deleteAlbum.*' => [
                'bail',
                'nullable',
                'string',
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
                'imageMaxInAlbum'
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
        if ($this->has('teamAlbum')) {
            $teamAlbumTotal += count($this->file('teamAlbum'));
        }

        if ($this->has('deleteAlbum')) {
            $teamAlbumTotal -= count($this->input('deleteAlbum'));
        }

        // 現在のチームのアルバムとして登録された画像の枚数を取得し加算する
        $team = TeamMember::query()->where(['user_id' => Auth::id()])->first();
        $imageAlbums = TeamAlbum::query()->where(['team_id' => $team->team_id])->get();
        $teamAlbumTotal += count($imageAlbums);

        $this->merge(['teamAlbumTotal' => $teamAlbumTotal]);
    }
}
