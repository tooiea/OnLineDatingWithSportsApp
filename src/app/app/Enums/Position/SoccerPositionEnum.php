<?php

namespace App\Enums\Position;

enum SoccerPositionEnum: int
{
    case GK = 1;

    // DF
    case CB = 2;
    case RB = 3;
    case LB = 4;
    case RWB = 5;
    case LWB = 6;

    // MF
    case DMF = 7;
    case CMF = 8;
    case AMF = 9;
    case RMF = 10;
    case LMF = 11;

    // FW
    case RWG = 12;
    case LWG = 13;
    case CF = 14;
    case ST = 15;

    public function label(): string
    {
        return match ($this) {
            self::GK => 'ゴールキーパー（GK）',

            self::CB => 'センターバック（CB）',
            self::RB => '右サイドバック（RB）',
            self::LB => '左サイドバック（LB）',
            self::RWB => '右ウイングバック（RWB）',
            self::LWB => '左ウイングバック（LWB）',

            self::DMF => 'ディフェンシブMF（DMF／ボランチ）',
            self::CMF => 'セントラルMF（CMF）',
            self::AMF => 'オフェンシブMF（AMF）',
            self::RMF => '右サイドMF（RMF）',
            self::LMF => '左サイドMF（LMF）',

            self::RWG => '右ウイング（RWG）',
            self::LWG => '左ウイング（LWG）',
            self::CF => 'センターフォワード（CF）',
            self::ST => 'セカンドトップ（ST）',
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
