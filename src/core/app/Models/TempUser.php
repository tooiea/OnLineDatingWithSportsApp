<?php

namespace App\Models;

use App\Constants\CommonConstant;
use App\Mail\TempUserSendMailer;
use App\Notifications\TempUserNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{
    use HasFactory;

    protected $connection = 't_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token',
        'expiration_date',
    ];

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
     * 仮登録メール送信
     *
     * @param string $token
     * @return void
     */
    public function temporaryRegistrationNotification($token)
    {
        $this->notify(new TempUserNotification($token, new TempUserSendMailer()));
    }
}
