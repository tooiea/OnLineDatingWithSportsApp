<?php

namespace App\Enums\Position;

enum BasketballPositionEnum: int
{
    case PG = 1;
    case SG = 2;
    case SF = 3;
    case PF = 4;
    case C = 5;

    public function label(): string
    {
        return match ($this) {
            self::PG => 'ポイントガード（PG）',
            self::SG => 'シューティングガード（SG）',
            self::SF => 'スモールフォワード（SF）',
            self::PF => 'パワーフォワード（PF）',
            self::C => 'センター（C）',
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
