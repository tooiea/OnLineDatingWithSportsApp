<?php

namespace App\Models;

class Images
{
    /**
     *  画像からMIME TYPEとパスを取得
     *
     * @param object $image
     * @return array
     */
    public static function getImageDetail($image)
    {
        $tempPath = $image->store('public/upload/images');
        $storeImage['teamLogo'] = 'public/' . str_replace('public/', 'storage/', $tempPath);
        $storeImage['image_extension'] = $image->getMimeType();

        return $storeImage;
    }
}
