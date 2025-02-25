<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $uuid
 * @property string $imageable_type
 * @property string $imageable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Image extends Model
{
    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }
}
