<?php
declare(strict_types=1);
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $uuid
 * @property string $messageable_type
 * @property string $messageable_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Message extends Model
{
    use HasUuids;

    /**
     * 共通メッセージ
     *
     * @return MorphTo
     */
    public function messageable(): MorphTo
    {
        return $this->morphTo();
    }
}
