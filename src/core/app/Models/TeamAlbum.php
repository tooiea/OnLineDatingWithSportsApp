<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

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
        'image_name',
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
            $album = TeamAlbum::query()->where(['id' => Crypt::decryptString($id)])->first();
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
    public static function numberOfImageInMax($images)
    {
        // チームのアルバム枚数が規定の枚数以内であるかをチェック
        if ($images > self::MAX_QTY_IN_ALBUM) {
            return false;
        }

        return true;
    }
}
