<?php
declare(strict_types=1);
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $id
 * @property string $albumable_type
 * @property string $albumable_id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Album extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'albumable_type',
        'albumable_id',
        'name',
    ];

    /**
     * アルバム
     *
     * @return MorphTo
     */
    public function albumable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * チームコード
     *
     * @return MorphOne
     */
    public function image() : MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * アルバムに紐づく画像の存在チェック
     *
     * @param string $imageId
     * @return boolean
     */
    public static function existTeamAlbum(string $imageId): bool
    {
        return self::where('albumable_type', Team::class)
            ->whereRelation('image', 'id', $imageId)
            ->exists();
    }
}
