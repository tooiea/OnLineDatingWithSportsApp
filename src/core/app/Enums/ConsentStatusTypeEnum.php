<?php

namespace App\Enums;

enum ConsentStatusTypeEnum: int
{
case WAIT = 1;
case ACCEPTED = 2;
case DECLINED = 3;

    public function label(): string
    {
        return match ($this) {
            self::WAIT => '連絡未',
            self::ACCEPTED => '試合日時決定',
            self::DECLINED => '試合不可',
        };
    }

    public function className(): string
    {
        return match ($this) {
            self::WAIT => 'wait',
            self::ACCEPTED => 'accepted',
            self::DECLINED => 'declined',
        };
    }
    }
