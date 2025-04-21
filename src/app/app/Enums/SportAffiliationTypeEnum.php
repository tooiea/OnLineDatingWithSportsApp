<?php

namespace App\Enums;

use App\Enums\Handedness\BaseballHandednessEnum;
use App\Enums\Handedness\HandednessEnum;
use App\Enums\Position\BaseballPositionEnum;
use App\Enums\Position\BasketballPositionEnum;
use App\Enums\Position\SoccerPositionEnum;
use App\Enums\Position\VolleyballPositionEnum;

enum SportAffiliationTypeEnum: int
{
    case BASEBALL = 1;
    case SOCCER = 2;
    case BASKET_BALL = 3;
    case VOLLEY_BALL = 4;

    /**
     * ラベル
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::BASEBALL => '野球',
            self::SOCCER => 'サッカー',
            self::BASKET_BALL => 'バスケットボール',
            self::VOLLEY_BALL => 'バレーボール',
        };
    }

    /**
     * スポーツ種別リスト
     *
     * @return array
     */
    public static function list(): array
    {
        return array_map(fn($e) => [
            'value' => $e->value,
            'label' => $e->label(),
        ], self::cases());
    }

    /**
     * スポーツごとのポジションリスト
     *
     * @return array
     */
    public function positions(): array
    {
        return match ($this) {
            self::BASEBALL => BaseballPositionEnum::list(),
            self::SOCCER => SoccerPositionEnum::list(),
            self::BASKET_BALL => BasketballPositionEnum::list(),
            self::VOLLEY_BALL => VolleyballPositionEnum::list(),
        };
    }

    /**
     * バリデーション:ポジション
     *
     * @return string
     */
    public function positionClass(): string
    {
        return match ($this) {
            self::BASEBALL => BaseballPositionEnum::class,
            self::SOCCER => SoccerPositionEnum::class,
            self::BASKET_BALL => BasketballPositionEnum::class,
            self::VOLLEY_BALL => VolleyballPositionEnum::class,
        };
    }

    /**
     * スポーツ種別、ポジションの値からラベル取得
     *
     * @param integer $position
     * @return string|null
     */
    public function positionFrom(int $position): ?string
    {
        $enumClass = $this->positionClass();

        if (!enum_exists($enumClass)) {
            return null;
        }

        try {
            /** @var \BackedEnum $enumClass */
            $enum = $enumClass::tryFrom($position);
            return $enum?->label();
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * スポーツごとの利き手リスト
     *
     * @return array
     */
    public function handedness(): array
    {
        return match ($this) {
            self::BASEBALL => BaseballHandednessEnum::list(),
            self::SOCCER => HandednessEnum::list(),
            self::BASKET_BALL => HandednessEnum::list(),
            self::VOLLEY_BALL => HandednessEnum::list(),
        };
    }

    /**
     * バリデーション:利き手
     *
     * @return string
     */
    public function handednessClass(): string
    {
        return match ($this) {
            self::BASEBALL => BaseballHandednessEnum::class,
            self::SOCCER => HandednessEnum::class,
            self::BASKET_BALL => HandednessEnum::class,
            self::VOLLEY_BALL => HandednessEnum::class,
        };
    }

    /**
     * スポーツ種別、利き手の値からラベル取得
     *
     * @param integer $handedness
     * @return string|null
     */
    public function handednessFrom(int $handedness): ?string
    {
        $enumClass = $this->handednessClass();

        if (!enum_exists($enumClass)) {
            return null;
        }

        try {
            /** @var \BackedEnum $enumClass */
            $enum = $enumClass::tryFrom($handedness);
            return $enum?->label();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
