<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\ConsentStatusTypeEnum;

class ConsentGameReply
{
    private readonly int $first_preferered_date;
    private readonly int $second_preferered_date;
    private readonly ?int $third_preferered_date;
    private readonly ?string $message;
    private ?int $status;

    public function __construct(
        int $first_preferered_date,
        int $second_preferered_date,
        ?int $third_preferered_date,
        ?string $message
    ) {
        $this->first_preferered_date = $first_preferered_date;
        $this->second_preferered_date = $second_preferered_date;
        $this->third_preferered_date = $third_preferered_date;
        $this->message = $message;
    }

    /**
     * セッションから取得した値を返す
     *
     * @return array
     */
    public function getAll(): array
    {
        return [
            'first_preferered_date' => $this->first_preferered_date,
            'second_preferered_date' => $this->second_preferered_date,
            'third_preferered_date' => $this->third_preferered_date,
            'message' => $this->message,
        ];
    }

    /**
     * 返信内容を取得
     *
     * @return string
     */
    public function getPreferedDate(): string
    {
        // 優先が高くかつ、受諾した日付を取得
        $preferedDate = '';
        $this->status = ConsentStatusTypeEnum::DECLINED->value; // 初期値
        $prefereDates = [
            'first_preferered_date' => $this->first_preferered_date,
            'second_preferered_date' => $this->second_preferered_date,
            'third_preferered_date' => $this->third_preferered_date,
        ];

        foreach ($prefereDates as $key => $value) {
            if ($value === ConsentStatusTypeEnum::ACCEPTED->value) {
                $preferedDate = $key;
                $this->status = ConsentStatusTypeEnum::ACCEPTED->value;
                break;
            }
        }
        return $preferedDate;
    }

    /**
     * 返信ステータスを取得
     *
     * @return string|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }
}
