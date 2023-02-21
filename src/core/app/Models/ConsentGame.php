<?php

namespace App\Models;

use App\Mail\SendMailer;
use App\Notifications\ConsentGameNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ConsentGame extends Model
{
    use HasFactory;
    use Notifiable;

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

        // 登録
        $this->create($customValues);
        $query = TeamMember::where('team_id', $customValues['invitee_id']);
        $user = $query->with('user')->first();

        // メール送信
        $this->consentGameNotification($customValues, $user);
    }

    /**
     * 招待お知らせメール送信
     *
     * @param array $customValues
     * @param object $user
     * @return void
     */
    public function consentGameNotification($customValues, $user)
    {
        $this->notify(new ConsentGameNotification($customValues, $user, new SendMailer()));
    }
}
