<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Not;

class Team extends Model
{
    use HasFactory;

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
        return $teamId;
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
        if (!empty($values['prefecture'])) {
            $query = $this->where('prefecture', '=', $values['prefecture']);
        } else {
            $query = $this->where('prefecture', '=', $myTeam->team->prefecture);
        }

        if (!empty($values['address'])) {
            $query->where('address', 'like', '%' . $values['address'] . '%');
        }
        $query->whereRaw("Not(id=$myTeam->team_id)"); // 自チームを除外
        $teams = $query->paginate(10);

        return $teams;
    }
}
