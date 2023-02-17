<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Not;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_name',
        'sport_affiliation_type',
        'invitation_code',
        'prefecture',
        'address',
        'team_logo',
        'image_extension',
        'is_deleted',
    ];

    /**
     * 招待コードから存在しているteamのidを取得
     *
     * @param string $invitationCode
     * @return void
     */
    public function getTeamIdByInvitationCode($invitationCode)
    {
        $teamId = $this->where('invitation_code', $invitationCode)
                ->select(['id'])->first();
        return $teamId->id;
    }

    /**
     * 仮登録されたユーザ情報から本登録後のユーザとしてチームを登録
     *
     * @param object $tempUser
     * @param string $invitationCode
     * @return int
     */
    public function registerTeam($tempUser, $invitationCode)
    {
        $teamId = $this->insertGetId([
            'team_name' => $tempUser->team_name,
            'sport_affiliation_type' => $tempUser->sport_affiliation_type,
            'invitation_code' => $invitationCode,
            'prefecture' => $tempUser->prefecture,
            'address' => $tempUser->address,
            'team_url' => $tempUser->team_url,
            'team_logo' => $tempUser->team_logo,
            'image_extension' => $tempUser->image_extension,
        ]);

        return $teamId;
    }

    /**
     * チーム情報を取得
     *
     * @param object $myTeam
     * @param array $values
     * @return object
     */
    public function getTeamBySearchQuery($myTeam, $values)
    {
        $query = $this; // 全件取得(初期値)

        // 都道府県
        if (!empty($values['prefecture'])) {
            $query = $query->where('prefecture', '=', $values['prefecture']);
        } elseif (!empty($myTeam)) {
            $query = $query->where('prefecture', '=', $myTeam->team->prefecture);
        }

        // 住所
        if (!empty($values['address'])) {
            $query->where('address', 'like', '%' . $values['address'] . '%');
        }

        // 自チーム登録なし
        if (!is_null($myTeam)) {
            $query->where('id', '<>', $myTeam->team_id); // 自チームを除外
        }
        return $query->paginate(10);
    }

    /**
     * 招待コードでチーム情報を取得
     *
     * @param string $invitation_code
     * @return object
     */
    public function getTeamInfoByInvitationCodeWithConsents($invitation_code)
    {
        $query = $this->where('invitation_code', $invitation_code);
        $query->leftJoin('consent_games', 'consent_games.invitee_id', 'teams.id');

        return $query->first();
    }
}
