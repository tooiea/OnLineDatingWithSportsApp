<?php

namespace App\Enums;

enum ConsentStatusTypeEnum: int
{
    case WAIT = 1;
    case ACCEPT = 2;
    case REJECT = 3;

    public function label(): string
    {
        return match ($this) {
            self::WAIT => '承認待ち',
            self::ACCEPT => '承諾済み',
            self::REJECT => '試合不可',
        };
    }
}
