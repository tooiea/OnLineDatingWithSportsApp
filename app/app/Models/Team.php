<?php

namespace App\Models;

use Carbon\Carbon;
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
        'image_path',
        'image_extension',
        'is_deleted',
    ];

    public function consentGames()
    {
        return $this->hasMany(ConsentGame::class);
    }

    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class);
    }

    /**
     * 招待コードから存在しているteamのidを取得
     *
     * @param string $invitationCode
     * @return void
     */
    public static function getTeamIdByInvitationCode($invitationCode)
    {
        $teamId = Team::where('invitation_code', $invitationCode)->select(['id'])->first();
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
            'image_path' => $tempUser->image_path,
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
    public static function getTeamBySearchQuery($myTeam, $values)
    {
        $query = new Team(); // 全件取得(初期値)

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
     * 招待コードでチームに招待しているチーム情報を取得する
     *
     * @param string $invitation_code
     * @return object
     */
    public static function getTeamInfoByInvitationCodeWithConsents($invitation_code)
    {
        $query = Team::where('invitation_code', $invitation_code);

        return $query->first();
    }

    /**
     * 自分が招待する側で、登録するチーム(invitee, guest)で登録する
     *
     * @param array $customValues
     * @return array
     */
    public static function getTeamIds($customValues, $userId)
    {
        $myTeam = TeamMember::getTeamByUserId($userId);
        $teamIds['invitee_id'] = $myTeam->team->id;

        // 招待するチームのチームid
        $teamIds['guest_id'] = Team::getTeamInfoByInvitationCodeWithConsents($customValues['invitation_code'])->id;

        return $teamIds;
    }


    public static function getMyTeamMembersByUserId($userId)
    {
        $myTeam = TeamMember::getTeamByUserId($userId);
        $myTeamMembers = Team::where('id', '=', $myTeam->team_id)->with('teamMembers')->get();

        return $myTeamMembers;
    }
}
