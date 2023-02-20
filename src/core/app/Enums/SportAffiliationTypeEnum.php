<?php

namespace App\Enums;

enum SportAffiliationTypeEnum: int
{
    case BASEBALL = 1;

    public function label(): string
    {
        return match ($this) {
            self::BASEBALL => '野球',
        };
    }
}
