<?php

namespace App\Models;

use App\Constants\CommonConstant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 't_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'visitor_id',
        'name1',
        'name2',
        'ruby1',
        'ruby2',
        'birthday',
        'email',
        'password',
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
     * メールアドレスで本登録すみのユーザを取得
     *
     * @param string $email
     * @return void
     */
    public function getByEmail($email)
    {
        $user = $this->where([
            'email' => $email,
            'is_enabled' => CommonConstant::FLAG_ON,
        ])->first();

        return $user;
    }
}
