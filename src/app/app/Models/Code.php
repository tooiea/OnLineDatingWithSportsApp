<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    public function codeable()
    {
        return $this->morphTo();
    }
}
