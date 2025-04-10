<?php

namespace App\Enums;

enum TeamAlbumTypeEnum: int
{
case ALBUM = 1;

    public function label(): string
    {
        return match ($this) {
            self::ALBUM => 'チームアルバム',
        };
    }
    }
