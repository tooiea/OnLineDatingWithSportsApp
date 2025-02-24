<?php

namespace App\Models;

use App\Enums\SportAffiliationTypeEnum;
use App\Enums\Prefecture;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $team_name
 * @property SportAffiliationTypeEnum $sport_affiliation_type
 * @property string $invitation_code
 * @property Prefecture $prefecture_code
 * @property string $address
 * @property string $team_url
 * @property string $image_path
 * @property string $image_extension
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ConsentGame $consent_games
 * @property TeamMember $team_members
 */
class Team extends Model
{
    use HasUuids;

    protected $fillable = [
        'team_name',
        'sport_affiliation_type',
        'invitation_code',
        'prefecture_code',
        'address',
        'image_path',
        'image_extension',
        'deleted_at',
    ];

    public function consent_games()
    {
        return $this->hasMany(ConsentGame::class);
    }

    public function team_members()
    {
        return $this->hasMany(TeamMember::class);
    }
}
