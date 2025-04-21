<?php

namespace App\Enums\Position;

enum VolleyballPositionEnum: int
{
    case OH = 1;
    case MB = 2;
    case OP = 3;
    case S  = 4;
    case L  = 5;

    public function label(): string
    {
        return match ($this) {
            self::OH => 'アウトサイドヒッター（OH）',
            self::MB => 'ミドルブロッカー（MB）',
            self::OP => 'オポジット（OP）',
            self::S  => 'セッター（S）',
            self::L  => 'リベロ（L）',
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
