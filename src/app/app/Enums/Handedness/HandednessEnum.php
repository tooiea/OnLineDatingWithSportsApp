<?php

namespace App\Enums\Handedness;

enum HandednessEnum: int
{
    case RIGHT = 1;
    case LEFT = 2;
    case BOTH = 3;

    public function label(): string
    {
        return match ($this) {
            self::RIGHT => '右利き',
            self::LEFT => '左利き',
            self::BOTH => '両利き',
        };
    }

    public static function list(): array
    {
        return array_map(
            fn($e) => ['value' => $e->value, 'label' => $e->label()],
            self::cases()
        );
    }
}
