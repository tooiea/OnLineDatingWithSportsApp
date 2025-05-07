<?php
declare(strict_types=1);
namespace App\Models;

class TeamRegister
{
    public readonly int $sportAffiliationType;
    public readonly string $teamName;
    public readonly TempFile $tempFile;
    public readonly ?string $teamUrl;
    public readonly int $prefecture;
    public readonly string $address;

    /**
     * 必要な入力値のみ受付
     *
     * @param integer $sportAffiliationType
     * @param string $teamName
     * @param TempFile $tempFile
     * @param string|null $teamUrl
     * @param integer $prefecture
     * @param string $address
     */
    public function __construct(
        int $sportAffiliationType,
        string $teamName,
        TempFile $tempFile,
        ?string $teamUrl,
        int $prefecture,
        string $address
    ) {
        $this->sportAffiliationType = $sportAffiliationType;
        $this->teamName = $teamName;
        $this->tempFile = $tempFile;
        $this->teamUrl = $teamUrl;
        $this->prefecture = $prefecture;
        $this->address = $address;
    }

    /**
     * セッションから取得した値を返す
     *
     * @return array
     */
    public function getAll(): array
    {
        return [
            'sportAffiliationType' => $this->sportAffiliationType,
            'teamName' => $this->teamName,
            'tempFile' => $this->tempFile,
            'teamUrl' => $this->teamUrl,
            'prefecture' => $this->prefecture,
            'address' => $this->address
        ];
    }
}
