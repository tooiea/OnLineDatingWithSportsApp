<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiBaseResource extends JsonResource
{
    public static $wrap = 'data';
}
