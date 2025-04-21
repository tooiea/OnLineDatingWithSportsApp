<?php

namespace App\Enums;

enum SoccerFootednessEnum: int
{
    case RIGHT = 1;
    case LEFT = 2;
    case BOTH = 3;

    public function label(): string
    {
        return match ($this) {
            self::RIGHT => '右利き（右足）',
            self::LEFT => '左利き（左足）',
            self::BOTH => '両利き（両足）',
        };
    }
}
