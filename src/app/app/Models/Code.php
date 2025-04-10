<?php
declare(strict_types=1);
namespace App\Models;

use Carbon\Carbon;
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

    /**
     * チームの招待コード存在確認
     *
     * @param string $code
     * @return boolean
     */
    public static function existTeamCode(string $code): bool
    {
        return self::where('codeable_type', Team::class)
            ->where('code', $code)
            ->where('expired_at', '>=', Carbon::now())
            ->exists();
    }
}
