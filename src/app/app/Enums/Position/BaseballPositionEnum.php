<?php

namespace App\Enums\Position;

enum BaseballPositionEnum: int
{
    case PITCHER = 1;
    case CATCHER = 2;
    case FIRST_BASE = 3;
    case SECOND_BASE = 4;
    case THIRD_BASE = 5;
    case SHORTSTOP = 6;
    case LEFT_FIELD = 7;
    case CENTER_FIELD = 8;
    case RIGHT_FIELD = 9;

    public function label(): string
    {
        return match ($this) {
            self::PITCHER => '投手',
            self::CATCHER => '捕手',
            self::FIRST_BASE => '一塁手',
            self::SECOND_BASE => '二塁手',
            self::THIRD_BASE => '三塁手',
            self::SHORTSTOP => '遊撃手',
            self::LEFT_FIELD => '左翼手',
            self::CENTER_FIELD => '中堅手',
            self::RIGHT_FIELD => '右翼手',
        };
    }

    public static function list(): array
    {
        return array_map(fn($e) => [
            'value' => $e->value,
            'label' => $e->label(),
        ], self::cases());
    }
}
