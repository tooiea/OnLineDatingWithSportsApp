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
use Ramsey\Uuid\Lazy\LazyUuidFromString;

/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
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
        return $this->morphOne(Code::class, 'codeable');
    }

    /**
     * 仮登録メール送信
     *
     * @param Ramsey\Uuid\Lazy\LazyUuidFromString $uuid
     * @param string $email
     * @return void
     */
    public function temporaryRegistrationNotification(LazyUuidFromString $uuid, string $email)
    {
        $this->notify(new TempTeamRegisterNotification([
            'admin' => $email,
            'url' => route('user.register', [$uuid]),
        ]));
    }
}
