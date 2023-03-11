<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Enums\ConsentStatusTypeEnum;
use App\Http\Requests\ConsentGameIdRequest;
use App\Http\Requests\ConsentGameReplyRequest;
use App\Http\Requests\ConsentScheduleRequest;
use App\Http\Requests\TempUserInvitationCodeRequest;
use App\Models\ConsentGame;
use App\Models\Reply;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ConsentGamesController extends Controller
{
    private $team;
    private $teamMember;
    private $consentGame;
    private $reply;
    /**
     * モデルインスタンスセット
     *
     * @param Team $team
     */
    public function __construct(Team $team, TeamMember $teamMember, ConsentGame $consentGame, Reply $reply)
    {
        $this->team = $team;
        $this->teamMember = $teamMember;
        $this->consentGame = $consentGame;
        $this->reply = $reply;
    }

    /**
     * 招待チームと招待フォーム表示
     * 既に招待していて、期限切れや返事待ちの時はフォームを出さない
     *
     * @param TempUserInvitationCodeRequest $request
     * @param string $invitation_code
     * @return void
     */
    public function index(TempUserInvitationCodeRequest $request, $invitation_code)
    {
        // 招待先のチーム情報と招待情報の取得
        session(['consent_invitaion_code' => $invitation_code]);
        $guestTeam = $this->team->getTeamInfoByInvitationCodeWithConsents($invitation_code);

        // TODO 招待中は、表示を招待中に変更

        return view('consentGames.index', compact('guestTeam'));
    }

    /**
     * 招待内容の確認画面
     *
     * @param ConsentScheduleRequest $request
     * @return void
     */
    public function confirm(ConsentScheduleRequest $request)
    {
        $values['invitation_code'] = $request->session()->pull('consent_invitaion_code');
        $values = array_merge($values, $request->input());
        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($values, FormConstant::CONSENT_FORM_KEYS); // インスタンスをセッションへ
        session(['consent_team' => $specifyFormRequestInputs]);

        return view('consentGames.confirm', compact('values'));
    }

    /**
     * 招待相手にメール送信、DB登録
     * 登録後にMyチームページへリダイレクト
     *
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        $specifyFormRequestInputs = $request->session()->pull('consent_team');
        $customValues = $specifyFormRequestInputs->getAll();
        $teamIds = $this->getTeamIds($customValues);

        DB::transaction(function () use ($customValues, $teamIds) {
            // 試合招待テーブルへ登録、メール送信
            $this->consentGame->createConsent($customValues, $teamIds);
        });
    }

    /**
     * 登録するチームidを取得
     *
     * @param array $customValues
     * @return array
     */
    private function getTeamIds($customValues)
    {
        $myTeam = $this->teamMember->getTeamByUserId(Auth::id());
        $teamIds['invitee_id'] = $myTeam->team->id;
        $teamIds['guest_id'] = $this->team->getTeamInfoByInvitationCodeWithConsents($customValues['invitation_code'])->id; // チーム情報取得

        return $teamIds;
    }

    public function detail(ConsentGameIdRequest $request, $consent_game_id)
    {
        // $consents = $this->getConsentsGame($consent_game_id);
        $replies = $this->consentGame->getRepliesByConsentGameId(Crypt::decryptString($consent_game_id));

        // dd($replies);
        return view('consentGames.reply_detail', compact('replies'));
    }

    /**
     * 試合招待への返信
     *
     * @param ConsentGameIdRequest $request
     * @param string $consent_game_id
     * @return void
     */
    public function reply(ConsentGameIdRequest $request, $consent_game_id)
    {
        // チームのトップ一覧から招待情報の一覧を表示
        // 既に返信済みであれば、ボタンを表示せずに、回答内容だけを表示するように切り替える
        session(['consent_game_id' => $consent_game_id]);
        $consents = $this->getConsentsGame($consent_game_id);

        return view('consentGames.reply', compact('consents'));
    }

    /**
     * 招待ゲーム詳細を取得
     *
     * @param string $consent_game_id
     * @return object
     */
    private function getConsentsGame($consent_game_id)
    {
        $id = Crypt::decryptString($consent_game_id);
        $consents = $this->consentGame->getConsentsGameById($id);

        return $consents;
    }

    /**
     * 試合招待返信の確認画面
     *
     * @param ConsentGameReplyRequest $request
     * @return void
     */
    public function confirmReply(ConsentGameReplyRequest $request)
    {
        // 入力値をセッションにセットし、画面用にセット
        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($request->all(), FormConstant::CONSENT_REPLY_FORM_KEYS);
        session(['consent_reply' => $specifyFormRequestInputs]);
        $values = $specifyFormRequestInputs->getAll(); // 返信入力値
        $consents = $this->getConsentsGame($request->session()->get('consent_game_id')); // 招待の詳細日程

        return view('consentGames.reply_confirm', compact('values', 'consents'));
    }

    public function completeReply(Request $request)
    {
        $consents = $this->getConsentsGame($request->session()->pull('consent_game_id')); // 招待の詳細日程
        $specifyFormRequestInputs = $request->session()->pull('consent_reply');
        $customValues = $specifyFormRequestInputs->getAll();

        DB::transaction(function () use ($consents, $customValues) {
            $this->consentGame->updateConsent($consents, $customValues);
            $this->reply->createReply($consents, $customValues);

            // TODO 以下を実装

            // メッセージ送信
            // 送信先は、入力した人とチームに最初に登録した人へメッセージを送信する

            // チームトップへリダイレクトしセッションメッセージ表示
        });
    }
}
