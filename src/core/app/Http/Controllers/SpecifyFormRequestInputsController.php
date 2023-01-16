<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecifyFormRequestInputsController extends Controller
{
    private $values;
    private $specifyKeys;
    private $files; // ファイル

    public function setAll(array $values, array $specifyKeys, array $files = null)
    {
        $this->values = $values;
        $this->specifyKeys = $specifyKeys;
        $this->files = $files;
    }

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
