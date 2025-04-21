<?php

namespace App\Enums\Handedness;

enum BaseballHandednessEnum: int
{
    case RIGHT_THROW_RIGHT_HIT = 1;
    case RIGHT_THROW_LEFT_HIT = 2;
    case RIGHT_THROW_BOTH_HIT = 3;

    case LEFT_THROW_LEFT_HIT = 4;
    case LEFT_THROW_RIGHT_HIT = 5;
    case LEFT_THROW_BOTH_HIT = 6;

    case BOTH_THROW_RIGHT_HIT = 7;
    case BOTH_THROW_LEFT_HIT = 8;
    case BOTH_THROW_BOTH_HIT = 9;

    public function label(): string
    {
        return match ($this) {
            self::RIGHT_THROW_RIGHT_HIT => '右投げ右打ち',
            self::RIGHT_THROW_LEFT_HIT => '右投げ左打ち',
            self::RIGHT_THROW_BOTH_HIT => '右投げ両打ち',

            self::LEFT_THROW_LEFT_HIT => '左投げ左打ち',
            self::LEFT_THROW_RIGHT_HIT => '左投げ右打ち',
            self::LEFT_THROW_BOTH_HIT => '左投げ両打ち',

            self::BOTH_THROW_RIGHT_HIT => '両投げ右打ち',
            self::BOTH_THROW_LEFT_HIT => '両投げ左打ち',
            self::BOTH_THROW_BOTH_HIT => '両投げ両打ち',
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
