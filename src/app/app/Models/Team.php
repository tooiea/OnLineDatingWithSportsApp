<?php

namespace App\Models;

use App\Enums\SportAffiliationTypeEnum;
use App\Enums\Prefecture;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property string $id
 * @property string $name
 * @property SportAffiliationTypeEnum $sport_affiliation_type
 * @property Prefecture $prefecture_code
 * @property string $address
 * @property string $url
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property ConsentGame $consent_games
 * @property TeamMember $team_members
 */
class Team extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'sport_affiliation_type',
        'prefecture_code',
        'address',
        'url',
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

    public function image() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function code() : MorphOne
    {
        return $this->morphOne(Code::class, 'codeable');
    }
}
