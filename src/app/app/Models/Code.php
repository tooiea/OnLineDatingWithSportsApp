<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasUuids;

    protected $fillable = [
        'codeable_type',
        'codeable_id',
        'code',
        'expired_at',
        'is_used',
        'used_at'
    ];

    public function codeable()
    {
        return $this->morphTo();
    }
}
