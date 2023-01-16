<?php

namespace App\Models;

use App\Constants\CommonConstant;
use App\Mail\TempUserSendMailer;
use App\Notifications\TempUserNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;

class TempUser extends Model
{
    use HasFactory;
    use Notifiable;

    protected $connection = 't_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sport_affiliation_type',
        'team_name',
        'team_logo',
        'team_url',
        'prefecture',
        'address',
        'name',
        'email',
        'password',
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
    public function temporaryRegistrationNotification($token, $email)
    {
        $this->notify(new TempUserNotification($token, $email, new TempUserSendMailer()));
    }

    public function registrationTempUser($customValues, $token)
    {
        $now = Carbon::now();

        // temp_usersテーブルへ登録
        $this->updateOrCreate(
            // 同一メールアドレスが存在するか
            ['email' => $customValues['email']],
            [
                // 挿入データ
                'sport_affiliation_type' => $customValues['sportAffiliationType'],
                'team_name' => $customValues['teamName'],
                'team_logo' => $customValues['teamLogo'],
                'team_url' => (isset($customValues['teamUrl'])) ? $customValues['teamUrl'] : null,
                'prefecture' => $customValues['prefecture'],
                'address' => $customValues['address'],
                'name' => $customValues['name'],
                'password' => Hash::make($customValues['password']),
                'email' => $customValues['email'],
                'token' => $token,
                'expiration_date' => $now->addHour(),
            ]
        );

        $this->temporaryRegistrationNotification($token, $customValues['email']);
    }
}
