<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\SportAffiliationTypeEnum;
use App\Enums\Prefecture;
use App\Notifications\TempTeamRegisterNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $token
 * @property Carbon $expiration_date
 * @property SportAffiliationTypeEnum $sport_affiliation_type
 * @property string $team_name
 * @property string $team_url
 * @property Prefecture $prefecture_code
 * @property string $address
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TempUser extends Model
{
    use HasUuids, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'expiration_date',
        'sport_affiliation_type',
        'team_name',
        'team_url',
        'prefecture_code',
        'address',
    ];

    public function image() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function code() : MorphOne
    {
        return $this->morphOne(Image::class, 'codeable');
    }

    /**
     * 仮登録メール送信
     *
     * @param string $uuid
     * @param string $email
     * @return void
     */
    public function temporaryRegistrationNotification(string $uuid, string $email)
    {
        $this->notify(new TempTeamRegisterNotification([
            'admin' => $email,
            'url' => route('team.register', [$uuid]),
        ]));
    }
}
