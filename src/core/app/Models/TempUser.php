<?php

namespace App\Models;

use App\Constants\CommonConstant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    use HasFactory;

    protected $connection = 't_users';

    /**
     * 仮登録中のトークンの有効期限をチェック
     *
     * @param string $token
     * @return object
     */
    public function checkExpiration($token)
    {
        $now = Carbon::now();
        $activeUser = $this->where([
            ['expiration_date','>=', $now],
            ['token', '=', $token],
        ])->first();
        return $activeUser;
    }

    /**
     * トークンからユーザのメールアドレスを取得
     *
     * @param string $token
     * @return object
     */
    public function getUserByToken($token)
    {
        $tmpUser = $this->where([
            'token' => $token,
        ])->select(['email'])->first();

        return $tmpUser;
    }

    /**
     * メールアドレスで本登録済み(有効化済み)のユーザをチェック
     *
     * @param string $email
     * @return object
     */
    public function getUserIsEnabled($email)
    {
        $user = $this->where('email', $email)
            ->where('is_enabled', CommonConstant::FLAG_OFF)
            ->join('temp_users', 'users.email', '=', 'temp_users.email')
            ->first();

        return $user;
    }
}
