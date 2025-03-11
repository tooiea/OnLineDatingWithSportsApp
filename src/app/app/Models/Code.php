<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasUuids;
    public function codeable()
    {
        return $this->morphTo();
    }
}
