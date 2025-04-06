<?php
declare(strict_types=1);
namespace App\Models;

class TempTeamJoinRegister
{
    public readonly string $nickname;
    public readonly string $email;
    public readonly string $password;

    /**
     * 必要な入力値のみ受付
     *
     * @param string $nickname
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $nickname,
        string $email,
        string $password
    ) {
        $this->nickname = $nickname;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * セッションから取得した値を返す
     *
     * @return array
     */
    public function getAll(): array
    {
        return [
            'nickname' => $this->nickname,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
