<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * フォーム入力された値を整形
 * セッション持ち回りするため
 */
class SpecifyFormRequestInputsController extends Controller
{
    private $values;
    private $specifyKeys;
    private $files; // ファイル

    /**
     * フォームに入力された値を指定のキーのみ抽出
     *
     * @param array $values
     * @param array $specifyKeys
     * @param array|null $files
     * @return void
     */
    public function setAll(array $values, array $specifyKeys, array $files = null)
    {
        $this->values = $values;
        $this->specifyKeys = $specifyKeys;
        $this->files = $files;
    }

    /**
     * 整形されたフォームの入力値を取得
     *
     * @return array
     */
    public function getAll()
    {
        $backInputs = [];
        foreach ($this->specifyKeys as $key) {
            if (isset($this->values[$key])) {
                $backInputs[$key] = $this->values[$key];
            }
        }

        // ファイルがある場合
        if (!is_null($this->files)) {
            foreach ($this->files as $key => $value) {
                $backInputs[$key] = $value;
            }
        }

        return $backInputs;
    }
}
