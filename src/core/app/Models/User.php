<?php

namespace App\Models;

use App\Constants\CommonConstant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $connection = 't_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name1',
        'name2',
        'ruby1',
        'ruby2',
        'birthday',
        'email',
        'password',
        'invitation_code',
        'expiration_date',
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
}
