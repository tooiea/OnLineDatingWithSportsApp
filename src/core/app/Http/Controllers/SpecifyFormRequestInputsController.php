<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpecifyFormRequestInputsController extends Controller
{
    private $values;
    private $specifyKeys;

    public function setAll(array $values, array $specifyKeys)
    {
        $this->values = $values;
        $this->specifyKeys = $specifyKeys;
    }

    public function getAll()
    {
        $backInputs = [];
        foreach ($this->specifyKeys as $key) {
            $backInputs[$key] = $this->values[$key];
        }

        return $backInputs;
    }
}
