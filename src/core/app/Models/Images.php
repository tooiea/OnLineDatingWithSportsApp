<?php

namespace App\Models;

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

        // 保存後にディレクトリを取得
        $savedDir = $image->storeAs('public/' . self::DIRECTORY_OLDWS_LOGO, $fileName);
        $storeImage['teamLogo'] = $savedDir;
        $storeImage['image_extension'] = $image->getMimeType();

        return $storeImage;
    }
}
