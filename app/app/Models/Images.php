<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

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
        $storeImage = Images::saveImage($image, $fileName, self::DIRECTORY_OLDWS_LOGO);

        return $storeImage;
    }

    /**
     * アルバムとして画像を保存し、画像からMIME TYPEとパスを取得
     *
     * @param UploadedFile $image
     * @return array
     */
    public static function getAlbumImageDetail($image)
    {
        // ファイル名を生成
        $fileName = Files::getFileNameWithUniqueDate($image->guessExtension());

        // 保存後にディレクトリを取得
        $storeImage = Images::saveImage($image, $fileName, self::DIRECTORY_OLDWS_ALBUM);

        return $storeImage;
    }


    /**
     * 画像の保存後に、画像情報を取得する
     *
     * @param UploadedFile   $image
     * @param string         $fileName
     * @param string         $dir
     * @return array
     */
    private static function saveImage($image, $fileName, $dir)
    {
        $path = $image->storeAs($dir, $fileName);
        $storeImage['imagePath'] = $path;
        $storeImage['imageExtension'] = $image->getMimeType();

        return $storeImage;
    }

    public static function deleteImagefrom($path)
    {
        Storage::delete($path);
    }
}
