<?php
declare(strict_types=1);
namespace App\Models;

class TempTeamRegister
{
    public readonly string $nickname;
    public readonly string $email;
    public readonly string $password;
    public readonly string $password2;
    public readonly int $sportAffiliationType;
    public readonly string $teamName;
    public readonly TempFile $tempFile;
    public readonly ?string $teamUrl;
    public readonly int $prefecture;
    public readonly string $address;

    /**
     * 必要な入力値のみ受付
     *
     * @param string $nickname
     * @param string $email
     * @param string $password
     * @param string $password2
     * @param integer $sportAffiliationType
     * @param string $teamName
     * @param TempFile $tempFile
     * @param string|null $teamUrl
     * @param integer $prefecture
     * @param string $address
     */
    public function __construct(
        string $nickname,
        string $email,
        string $password,
        string $password2,
        int $sportAffiliationType,
        string $teamName,
        TempFile $tempFile,
        ?string $teamUrl,
        int $prefecture,
        string $address
    ) {
        $this->nickname = $nickname;
        $this->email = $email;
        $this->password = $password;
        $this->password2 = $password2;
        $this->sportAffiliationType = $sportAffiliationType;
        $this->teamName = $teamName;
        $this->tempFile = $tempFile;
        $this->teamUrl = $teamUrl;
        $this->prefecture = $prefecture;
        $this->address = $address;
    }

    public function getAll()
    {
        return [
            'nickname' => $this->nickname,
            'email' => $this->email,
            'password' => $this->password,
            'password2' => $this->password2,
            'sportAffiliationType' => $this->sportAffiliationType,
            'teamName' => $this->teamName,
            'tempFile' => $this->tempFile,
            'teamUrl' => $this->teamUrl,
            'prefecture' => $this->prefecture,
            'address' => $this->address
        ];
    }
}
