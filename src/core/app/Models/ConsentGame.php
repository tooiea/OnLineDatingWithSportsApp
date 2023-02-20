<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsentGame extends Model
{
    use HasFactory;

    protected $fillable = [
        'invitee_id',
        'guest_id',
        'consent_status',
        'game_date',
        'first_preferered_date',
        'second_preferered_date',
        'third_preferered_date',
        'message',
        'is_deleted',
    ];

    /**
     * 招待履歴を登録する
     *
     * @param array $customValues
     * @param array $teamIds
     * @return void
     */
    public function createConsent($customValues, $teamIds)
    {
        $customValues['consent_status'] = \App\Enums\ConsentStatusTypeEnum::WAIT->value;
        $customValues['invitee_id'] = $teamIds['invitee_id']; // Myteamのteam_id
        $customValues['guest_id'] = $teamIds['guest_id']; // 招待するチームのteam_id

        $this->create($customValues);
    }
}
