<?php

namespace App\Models;

use App\Constants\FormConstant;
use App\Enums\ConsentStatusTypeEnum;
use App\Mail\SendMailer;
use App\Notifications\ConsentGameNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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
     * Undocumented function
     *
     * @return void
     */
    public function reply()
    {
        return $this->hasMany(Reply::class, 'consent_game_id');
    }

    /**
     * 招待履歴を登録する
     *
     * @param array $customValues
     * @param array $teamIds
     * @return void
     */
    public function createConsent($customValues, $teamIds)
    {
        $customValues['consent_status'] = ConsentStatusTypeEnum::WAIT->value;
        $customValues['invitee_id'] = $teamIds['invitee_id']; // Myteamのteam_id
        $customValues['guest_id'] = $teamIds['guest_id']; // 招待するチームのteam_id

        // 登録
        $this->create($customValues);
        $guest = TeamMember::where('team_id', $customValues['guest_id'])->first();
        $invitee = TeamMember::where('team_id', $customValues['invitee_id'])->with('user')->first();

        // メール送信
        $this->consentGameNotification($customValues, $guest, $invitee);
    }

    /**
     * 招待お知らせメール送信
     *
     * @param array $customValues
     * @param object $user
     * @param object $myTeam
     * @return void
     */
    public function consentGameNotification($customValues, $user, $invitee)
    {
        $this->notify(new ConsentGameNotification($customValues, $user, $invitee, new SendMailer()));
    }

    /**
     * My Teamで招待したチーム情報を取得する
     *
     * @param int $teamId
     * @return object
     */
    public function getMyTeamInvites($teamId)
    {
        $now = Carbon::now();
        $query = $this->where('invitee_id', $teamId);
        $query->Where(function ($query) use ($now) {
            $query->orwhere('first_preferered_date', '>=', $now);
            $query->orwhere('second_preferered_date', '>=', $now);
            $query->orwhere('third_preferered_date', '>=', $now);
        });
        $query->join('teams', 'teams.id', '=', 'consent_games.guest_id');
        $query->select(
            'consent_games.id as consent_games_id',
            'consent_games.*',
            'consent_games.created_at as consent_games_created_at',
            'teams.id as team_id',
            'teams.*',
            'teams.created_at as team_created_at'
        );
        $myTeam = $query->get();
        return $myTeam;
    }

    /**
     * ゲスト側で招待のあったチーム情報を取得
     *
     * @param int $teamId
     * @return object
     */
    public function getAsGuestInvites($teamId)
    {
        $now = Carbon::now();
        $query = $this->where('guest_id', $teamId);
        $query->Where(function ($query) use ($now) {
            $query->orwhere('first_preferered_date', '>=', $now);
            $query->orwhere('second_preferered_date', '>=', $now);
            $query->orwhere('third_preferered_date', '>=', $now);
        });
        $query->join('teams', 'teams.id', '=', 'consent_games.invitee_id');
        $query->select(
            'consent_games.id as consent_games_id',
            'consent_games.*',
            'consent_games.created_at as consent_games_created_at',
            'teams.id as team_id',
            'teams.*',
            'teams.created_at as team_created_at'
        );
        $myTeam = $query->get();
        return $myTeam;
    }

    /**
     * 詳細ページに表示する試合の招待情報を表示する
     *
     * @param int $consentId
     * @return object
     */
    public function getConsentsGameById($consentId)
    {
        $now = Carbon::now();
        $query = $this->where('consent_games.id', $consentId);
        $query->where(function ($query) use ($now) {
            $query->orwhere('first_preferered_date', '>=', $now);
            $query->orwhere('second_preferered_date', '>=', $now);
            $query->orwhere('third_preferered_date', '>=', $now);
        });
        $query->join('teams', 'teams.id', '=', 'consent_games.guest_id');
        $query->select('consent_games.id as consent_games_id', 'consent_games.*', 'teams.*');
        $consents = $query->first();

        return $consents;
    }

    /**
     * 返信入力内容を登録
     *
     * @param object $consents
     * @param array $customValues
     * @return void
     */
    public function updateConsent($consents, $customValues)
    {
        $updateConsent = $this->where('id', $consents->consent_games_id)->first();
        $updateConsent->consent_status = ConsentStatusTypeEnum::DECLINED->value;
        $isAccept = $this->checkReplyIsAcceptance($customValues);
        // 承認された日程があれば、上書き
        if ($isAccept) {
            $updateConsent->consent_status = ConsentStatusTypeEnum::ACCEPTED->value;
            $desirableDateKey = $this->getAcceptanceDateByDesirableDate($customValues);
            $updateConsent->game_date = $consents[$desirableDateKey];
        }
        $updateConsent->save();
    }

    /**
     * 返信内容中に受諾された日程が存在するかをチェック
     *
     * @param array $customValues
     * @return boolean
     */
    private function checkReplyIsAcceptance($customValues)
    {
        $isAccept = false;

        if ($customValues['first_preferered_date'] == FormConstant::ACCEPT_VALUE) {
            return $isAccept = true;
        }
        if ($customValues['second_preferered_date'] == FormConstant::ACCEPT_VALUE) {
            return $isAccept = true;
        }
        if (isset($customValues['third_preferered_date']) && $customValues['third_preferered_date'] == FormConstant::ACCEPT_VALUE) {
            return $isAccept = true;
        }

        return $isAccept;
    }

    /**
     * 選択された返信の希望が高いものを選択する
     *
     * @param array $customValues
     * @return string
     */
    private function getAcceptanceDateByDesirableDate($customValues)
    {
        $desirableDateKey = '';
        foreach ($customValues as $key => $value) {
            if ('message' !== $key && $value == FormConstant::ACCEPT_VALUE) {
                $desirableDateKey = $key;
                break;
            }
        }
        return $desirableDateKey;
    }

    /**
     * 招待に対する返信情報を取得する
     *
     * @param int $consent_game_id
     * @return object
     */
    public function getRepliesByConsentGameId($consent_game_id)
    {
        // userのチームを取得
        $teamMemberModel = new TeamMember();
        $myTeam = $teamMemberModel->getTeamByUserId(Auth::user()->id);

        $query = $this->where('consent_games.id', '=', $consent_game_id);
        $query->join('teams as it', 'it.id', '=', 'consent_games.invitee_id');
        $query->join('teams as gt', 'gt.id', '=', 'consent_games.guest_id');
        $query->join('teams as myt', function ($join) use ($myTeam, $consent_game_id, $query) {
            $join->where('consent_games.id', '=', $consent_game_id);
            $join->where('myt.id', '=', $myTeam->team_id);
            $consent = $query->first();
            if ($consent->invitee_id === $myTeam->team_id) {
                $join->on('myt.id', '=', 'consent_games.invitee_id');
            } else {
                $join->on('myt.id', '=', 'consent_games.guest_id');
            }
        });
        $query->with('reply');
        $query->select(
            'consent_games.id as consent_games_id',
            'consent_games.*',
            'it.team_name as invite_team_name',
            'it.team_url as invite_team_url',
            'it.team_logo as invite_team_logo',
            'it.image_extension as invite_image_extension',
            'gt.team_name as guest_team_name',
            'gt.team_url as guest_team_url',
            'gt.team_logo as guest_team_logo',
            'gt.image_extension as guest_image_extension',
            'myt.id as my_team_id',
        );
        $replies = $query->first();

        return $replies;
    }
}
