<?php

namespace App\Models;

use App\Mail\SendMailer;
use App\Notifications\TempUserNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;

class TempUser extends Model
{
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
        'password',
        'token',
        'expiration_date',
        'sport_affiliation_type',
        'team_name',
        'image_path',
        'image_extension',
        'team_url',
        'prefecture',
        'address',
        'invitation_code',
    ];

    /**
     * 仮登録中のトークンの有効期限をチェック
     *
     * @param string $token
     * @return object
     */
    public static function checkExpiration($token)
    {
        $now = Carbon::now();
        $activeUser = TempUser::where([
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
    public static function getUserByToken($token)
    {
        $tmpUser = TempUser::where([
            'token' => $token,
        ])->first();

        return $tmpUser;
    }

    /**
     * 仮登録メール送信
     *
     * @param string $token
     * @param string $email
     * @return void
     */
    public function temporaryRegistrationNotification($token, $email)
    {
        $this->notify(new TempUserNotification($token, $email, new SendMailer()));
    }

    /**
     * 仮登録フォームで入力されたユーザとして登録
     *
     * @param array $customValues
     * @param string $token
     * @return void
     */
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
                'image_path' => $customValues['imagePath'],
                'image_extension' => $customValues['image_extension'],
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


    /**
     * 招待されたユーザを登録する
     *
     * @param array $customValues
     * @param string $token
     * @return void
     */
    public function registrationTempUserByInvitationCode($customValues, $token)
    {
        // invitation_codeを登録
        $now = Carbon::now();

        // temp_usersテーブルへ登録
        $this->updateOrCreate(
            // 同一メールアドレスが存在するか
            ['email' => $customValues['email']],
            [
                // 挿入データ
                'name' => $customValues['name'],
                'password' => Hash::make($customValues['password']),
                'email' => $customValues['email'],
                'invitation_code' => $customValues['invitation_code'],
                'token' => $token,
                'expiration_date' => $now->addHour(),
            ]
        );

        $this->temporaryRegistrationNotification($token, $customValues['email']);
    }
}
