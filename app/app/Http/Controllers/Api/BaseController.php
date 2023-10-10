<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public const STATUS_200 = 200;
    public const STATUS_400 = 400;

    /**
     * ステータス200_共通レスポンス内容
     *
     * @param  int $status
     * @param  array $data
     * @return array
     */
    public function commonResponse($message, $data, $statusCode)
    {
        $response = [
            'status' => $statusCode,
            'message' => $message,
            'conntent' => $data
        ];
        return response()->json($response, $statusCode);
    }
}
