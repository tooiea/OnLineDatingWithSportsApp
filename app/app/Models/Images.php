<?php

namespace App\Models;

/**
 * 画像ファイルの保存
 */
class Images
{
    private const DIRECTORY_OLDWS_TOP = 'oldws';
    private const DIRECTORY_OLDWS_LOGO = 'oldws/images/logo';
    private const DIRECTORY_OLDWS_ALBUM = 'oldws/images/album';

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
        $path = $image->storeAs(self::DIRECTORY_OLDWS_LOGO, $fileName);
        $storeImage['imagePath'] = $path;
        $storeImage['imageExtension'] = $image->getMimeType();

        return $storeImage;
    }
}
