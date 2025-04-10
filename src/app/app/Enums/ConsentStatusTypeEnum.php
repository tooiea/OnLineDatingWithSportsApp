<?php

namespace App\Enums;

enum ConsentStatusTypeEnum: int
{
    case WAIT = 0;
    case ACCEPTED = 1;
    case DECLINED = 2;

    /**
     * ステータスのラベルを取得
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::WAIT => '連絡未',
            self::ACCEPTED => '試合日時決定',
            self::DECLINED => '試合不可',
        };
    }

    /**
     * 返信内容のラベルを取得
     *
     * @return string
     */
    public function replyLabel(): string
    {
        return match ($this) {
            self::WAIT => '連絡未',
            self::ACCEPTED => '受諾',
            self::DECLINED => '辞退',
        };
    }

    /**
     * 適用するクラス名を取得
     *
     * @return string
     */
    public function className(): string
    {
        return match ($this) {
            self::WAIT => 'wait',
            self::ACCEPTED => 'accepted',
            self::DECLINED => 'declined',
        };
    }

    /**
     * 返信ステータスのリストを取得
     *
     * @return array
     */
    public static function replyList(): array
    {
        return array_map(
            fn($status) => ['id' => $status->value, 'label' => $status->replyLabel()],
            self::cases()
        );
    }
}
