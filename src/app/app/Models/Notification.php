<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $id
 * @property string $notifiable_type
 * @property string $notifiable_id
 * @property string $senderable_type
 * @property string $senderable_id
 * @property Carbon $read_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Notification extends Model
{
    use HasUuids;

    protected $fillable = [
        'notifiable_type',
        'notifiable_id',
        'senderable_type',
        'senderable_id',
        'read_at',
    ];

    /**
     * 通知
     *
     * @return MorphTo
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
