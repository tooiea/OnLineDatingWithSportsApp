<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamAlbum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'album_type',
        'image_extension',
    ];

    /**
     * アルバム内の最大枚数
     *
     * @var integer
     */
    private const MAX_QTY_IN_ALBUM = 5;

    /**
     * アルバムidが存在しているかをチェック
     *
     * @return boolean
     */
    public static function isExistIds($ids)
    {
        foreach ($ids as $id) {
            $album = TeamAlbum::find($id)->first();
            // 存在しないid
            if (empty($album)) {
                return false;
            }
        }
        return true;
    }

    /**
     * チームのアルバムの最大登録数のチェック
     *
     * @return boolean
     */
    public static function isNumberOfImageWithinMaximum()
    {
        // チームのアルバム枚数が規定の枚数以内であるかをチェック

        // チームを特定し、そのチームで登録されているアルバムとして登録されている画像の枚数を取得する
        // 削除用と登録用の画像枚数の合計を加算し、規定の枚数を超えているかチェック
    }
}
