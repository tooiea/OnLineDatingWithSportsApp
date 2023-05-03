<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

/**
 * 画像ファイルの保存
 */
class Images
{
    private const DIRECTORY_OLDWS_TOP = 'oldwds';
    private const DIRECTORY_OLDWS_LOGO = 'oldwds/images/logo';
    private const DIRECTORY_OLDWS_ALBUM = 'oldwds/images/album';

    /**
     *  画像からMIME TYPEとパスを取得
     *
     * @param object $image
     * @return array
     */
    public static function getImageDetail($image)
    {
        // ファイル名を生成
        $fileName = Files::getFileNameWithUniqueDate($image->guessExtension());

        // 環境ごとに保存ディレクトリを対応(保存後にディレクトリを取得)
        $savedDir = Storage::putFileAs(self::DIRECTORY_OLDWS_LOGO, $image, $fileName);

        $storeImage['teamLogo'] = $savedDir;
        $storeImage['image_extension'] = $image->getMimeType();

        return $storeImage;
    }
}
