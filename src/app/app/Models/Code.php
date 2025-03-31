<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    /**
     * 共通コード
     *
     * @return MorphTo
     */
    public function codeable(): MorphTo
    {
        return $this->morphTo();
    }
}
