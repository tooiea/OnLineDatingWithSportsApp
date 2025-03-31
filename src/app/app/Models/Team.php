<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\SportAffiliationTypeEnum;
use App\Enums\Prefecture;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * 招待試合
     *
     * @return HasMany
     */
    public function consent_games(): HasMany
    {
        return $this->hasMany(ConsentGame::class);
    }

    /**
     * チームメンバー
     *
     * @return HasMany
     */
    public function team_members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * チーム画像
     *
     * @return MorphOne
     */
    public function image() : MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * チームコード
     *
     * @return MorphOne
     */
    public function code() : MorphOne
    {
        return $this->morphOne(Code::class, 'codeable');
    }

    /**
     * 自チームの情報を取得
     *
     * @param string $userId
     * @return Team
     */
    public static function getMyTeamByUserId(string $userId): Team
    {
        return self::whereHas('team_members', function ($query) use ($userId) {
            $query->where('user_id', '=', $userId);
        })->first();
    }

    /**
     * 自チーム以外のチームを取得
     * 表示件数: 指定件数/ページ
     *
     * @param integer $pageNum
     * @param Team $myTeam
     * @param integer|null $prefecture
     * @param string|null $address
     * @param string|null $teamName
     * @return LengthAwarePaginator
     */
    public static function getOtherTeamsForPaginator(int $pageNum, Team $myTeam, ?int $prefecture, ?string $address, ?string $teamName): LengthAwarePaginator
    {
        $team = Team::query();

        // 検索条件
        $prefecture ? $team->where('prefecture_code', '=', $prefecture) : null;
        $address ? $team->where('address', 'like', '%' . $address . '%') : null;
        $teamName ? $team->where('name', 'like', '%' . $teamName . '%') : null;

        // 自チームを除外
        $myTeam ? $team->where('id', '<>', $myTeam->id) : null;
        $teams = $team->with(['code', 'image'])->paginate($pageNum);

        // ページネーションのクエリパラメータを設定
        $prefecture ? $teams->appends(['prefecture_code' => $prefecture]) : null;
        $address ? $teams->appends(['address' => $address]) : null;
        return $teams;
    }
}
