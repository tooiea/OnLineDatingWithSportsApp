<?php

namespace App\Enums;

enum SportAffiliationTypeEnum: int
{
    case BASEBALL = 1;
    case SOCCER = 2;
    case BASKET_BALL = 3;
    case VOLLEY_BALL = 4;

    public function label(): string
    {
        return match ($this) {
            self::BASEBALL => '野球',
            self::SOCCER => 'サッカー',
            self::BASKET_BALL => 'バスケットボール',
            self::VOLLEY_BALL => 'バレーボール',
        };
    }
}
