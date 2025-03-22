<?php

namespace App\Enums;

enum ConsentReplyStatusEnum : int
{
    case WAIT = 0;
    case ACCEPTED = 1;
    case DECLINED = 2;

    public function label(): string
    {
        return match ($this) {
            self::WAIT => '連絡未',
            self::ACCEPTED => '受諾',
            self::DECLINED => '辞退',
        };
    }
}
