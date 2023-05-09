<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * ファイルに関する共通処理を定義
 */
class Files
{
    /**
     * 拡張子を渡しユニークなファイル名を生成する
     *
     * @param 拡張子 $extension
     * @return string
     */
    public static function getFileNameWithUniqueDate($extension)
    {
        $today = Carbon::now()->format('y-m-d');
        $randomStr = Str::random(10);
        $fileName = sprintf('%s_%s.%s', $randomStr, $today, $extension);

        return $fileName;
    }
}
