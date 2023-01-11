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
}
