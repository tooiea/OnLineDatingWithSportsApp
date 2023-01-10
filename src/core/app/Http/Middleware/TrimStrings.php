<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * ホワイトスペース半角、全角削除
     * フリガナの変換追加
     *
     * @param string $key
     * @param mix $value
     * @return mix
     */
    protected function transform($key, $value)
    {
        // 処理不要カラム
        if (in_array($key, $this->except, true)) {
            return $value;
        }

        // ひらがなをカタカナへ変換
        if ($key === 'ruby1' || $key === 'ruby2') {
            $value = mb_convert_kana($value, "KC");
        }

        return is_string($value) ? preg_replace('/　|\s+/', '', $value) : $value;
    }
}
