<?php

namespace App\Models;

use App\Mail\SendMailer;
use App\Notifications\ConsentGameReplyNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Reply extends Model
{
    use Notifiable;
    use HasFactory;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $fillable = [
        'consent_game_id',
        'team_id',
        'message',
    ];

    /**
     * 返信内容を新規登録
     *
     * @param int $consent_games_id
     * @param array $customValues
     * @return void
     */
    public function createReply($consents, $customValues)
    {
        $values = [
            'consent_game_id' => $consents->consent_games_id,
            'team_id' => $consents->guest_id,
            'message' => '',
        ];

        if (isset($customValues['message'])) {
            $values['message'] = $customValues['message'];
        }

        $this->create($values);

        $queryTeamMember = TeamMember::where('team_id', $consents->invitee_id);
        $user = $queryTeamMember->with('user')->first();
        $myTeam = Team::where('id', $consents->guest_id)->first();

        // 返信の通知を送信
        $this->consentGameNotification($user, $myTeam);
    }

    /**
     * 招待への返信お知らせメール送信
     *
     * @param array $customValues
     * @param object $user
     * @return void
     */
    public function consentGameNotification($user, $myTeam)
    {
        $this->notify(new ConsentGameReplyNotification($user, $myTeam, new SendMailer()));
    }
}
