<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Http\Requests\ConsentGameIdRequest;
use App\Http\Requests\ConsentGameReplyRequest;
use App\Http\Requests\ConsentScheduleRequest;
use App\Http\Requests\InvitationCodeRequest;
use App\Models\ConsentGame;
use App\Models\Reply;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

/**
 * 試合への招待 | 試合へ招待された
 */
class ConsentGamesController extends Controller
{
    /**
     * 招待チームと招待フォーム表示
     *
     * @param InvitationCodeRequest $request
     * @param string $invitation_code
     * @return void
     */
    public function index(InvitationCodeRequest $request, $invitation_code)
    {
        // 招待先のチーム情報と招待情報の取得
        session(['consent_invitation_code' => $invitation_code]);
        $guestTeam = Team::getTeamInfoByInvitationCodeWithConsents($invitation_code);

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
        $values['invitation_code'] = $request->session()->pull('consent_invitation_code');
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

        // 招待チーム及び招待されるチームを取得
        $teamIds = Team::getTeamIds($customValues, Auth::id());

        DB::transaction(function () use ($customValues, $teamIds) {
            // 試合招待テーブルへ登録、メール送信
            $consentGameModel = new ConsentGame();
            $consentGameModel->createConsent($customValues, $teamIds);
        });

        // 招待されるチームの情報
        $guest = Team::where('id', $teamIds['guest_id'])->first();

        // チームトップへリダイレクトしセッションメッセージ表示
        $request->session()->flash('consent.sent', $guest->team_name . __('user_messages.success.consent_sent'));
        return redirect()->route('team.index');
    }

    /**
     * 招待された内容を表示
     * 返信があれば併せて取得して表示する
     *
     * @param ConsentGameIdRequest $request
     * @param string $consent_game_id
     * @return void
     */
    public function detail(ConsentGameIdRequest $request, $consent_game_id)
    {
        $replies = ConsentGame::getRepliesByConsentGameId(Crypt::decryptString($consent_game_id));

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
        $consents = ConsentGame::getConsentsGame($consent_game_id);

        return view('consentGames.reply', compact('consents'));
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

        // 招待の詳細日程
        $consents = ConsentGame::getConsentsGame($request->session()->get('consent_game_id'));

        return view('consentGames.reply_confirm', compact('values', 'consents'));
    }

    /**
     * 招待への返信の登録、メール送信、トップへリダイレクト
     *
     * @param Request $request
     * @return void
     */
    public function completeReply(Request $request)
    {
        // 招待の詳細日程
        $consents = ConsentGame::getConsentsGame($request->session()->pull('consent_game_id'));
        $specifyFormRequestInputs = $request->session()->pull('consent_reply');
        $customValues = $specifyFormRequestInputs->getAll();

        // 招待履歴の更新、返信内容を登録
        DB::transaction(function () use ($consents, $customValues) {
            // 試合招待へ登録
            $consentGameModel = new ConsentGame();
            $consentGameModel->updateConsent($consents, $customValues);

            // 返信詳細へ登録
            $replyModel = new Reply();
            $replyModel->createReply($consents, $customValues);
        });

        $invitee = Team::where('id', $consents->invitee_id)->first();

        // チームトップへリダイレクトしセッションメッセージ表示
        $request->session()->flash('consent.reply', $invitee->team_name . __('user_messages.success.reply_sent'));
        return redirect()->route('team.index');
    }
}
