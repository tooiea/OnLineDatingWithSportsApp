<?php
declare(strict_types=1);
namespace App\Models;

class ConsentGameInvite
{
    private readonly string $first_preferered_date;
    private readonly string $second_preferered_date;
    private readonly ?string $third_preferered_date;
    private readonly ?string $message;

    /**
     * 必要な入力値のみ受付
     *
     * @param string $first_preferered_date
     * @param string $second_preferered_date
     * @param string|null $third_preferered_date
     * @param string|null $message
     */
    public function __construct(
        string $first_preferered_date,
        string $second_preferered_date,
        ?string $third_preferered_date,
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
}
