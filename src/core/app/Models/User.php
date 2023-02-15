<?php

namespace App\Models;

use App\Constants\CommonConstant;
use App\Mail\SendMailer;
use App\Notifications\UserNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'line_login_id',
        'google_login_id',
        'password',
        'last_login_time',
        'is_deleted',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'reset_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * メールアドレスで本登録済みのユーザを取得
     *
     * @param string $email
     * @return boolean
     */
    public function getByEmail($email)
    {
        $user = $this->where(['email' => $email])->first();
        $isRegisterUser = false;

        if (!is_null($user)) {
            $isRegisterUser = true;
        }

        return $isRegisterUser;
    }

    /**
     * 仮ユーザ情報を元に本登録テーブルへ登録し、idを返却
     *
     * @param object $tempUser
     * @return string
     */
    public function registerUser($tempUser)
    {
        $userId = $this->insertGetId([
            'name' => $tempUser->name,
            'email' => $tempUser->email,
            'password' => $tempUser->password
        ]);

        return $userId;
    }

    /**
     * 本登録メール送信
     *
     * @param object $user
     * @return void
     */
    public function registrationNotification($user)
    {
        $this->notify(new UserNotification($user, new SendMailer()));
    }
}
