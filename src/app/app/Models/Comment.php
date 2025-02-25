<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $uuid
 * @property string $commentable_type
 * @property string $commentable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Comment extends Model
{
    public function commentable()
    {
        return $this->morphTo();
    }
}
