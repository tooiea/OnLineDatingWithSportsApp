<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function registerTeam($tempUser, $invitationCode)
    {
        $teamId = $this->insertGetId([
            'team_name' => $tempUser->name,
            'sport_affiliation_type' => $tempUser->sport_affiliation_type,
            'invitation_code' => $invitationCode,
            'prefecture' => $tempUser->prefecture,
            'address' => $tempUser->address,
        ]);

        return $teamId;
    }
}
