<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * @property string $uuid
 * @property string $imageable_type
 * @property string $imageable_id
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Image extends Model
{
    use HasUuids;

    /**
     * 追加フィールド
     *
     * @var array
     */
    protected $appends = ['path_base64'];

    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * 画像パスをbase64エンコードし返却
     *
     * @return string
     */
    public function getPathBase64Attribute(): string
    {
        if (!$this->path || !Storage::exists($this->path)) {
            throw new FileNotFoundException();
        }
        return "data:{$this->mime_type};base64," . base64_encode(Storage::get($this->path));
    }
}
