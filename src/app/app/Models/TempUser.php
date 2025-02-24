<?php

namespace App\Models;

use App\Enums\SportAffiliationTypeEnum;
use App\Enums\Prefecture;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $token
 * @property Carbon $expiration_date
 * @property SportAffiliationTypeEnum $sport_affiliation_type
 * @property string $team_name
 * @property string $image_path
 * @property string $image_extension
 * @property string $team_url
 * @property Prefecture $prefecture_code
 * @property string $address
 * @property string $invitation_code
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class TempUser extends Model
{
    use HasUuids;

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
        'prefecture_code',
        'address',
        'invitation_code',
    ];
}
