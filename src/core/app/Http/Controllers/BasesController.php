<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BasesController extends Controller
{
    /**
     * uuid取得
     *
     * @return string
     */
    public function createUuid()
    {
        $uuid = Str::uuid();
        return $uuid;
    }
}
