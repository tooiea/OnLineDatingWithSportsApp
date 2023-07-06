<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Http\Requests\TeamRegisterRequest;
use App\Http\Requests\TempTeamUserFormRequest;
use App\Models\Images;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * 仮ユーザ登録(チームを作成から)
 */
class TempTeamUsersController extends BasesController
{
    /**
     * フォーム入力
     *
     * @return void
     */
    public function index()
    {
        return view('tempTeamUsers.index');
    }

    /**
     * 入力値をセッションに保存
     * 画面用に値を再セット
     *
     * @param TempTeamUserFormRequest $request
     * @return void
     */
    public function confirm(TempTeamUserFormRequest $request)
    {
        // アップロードされた画像のmime_typeとパスを取得
        $files = Images::getImageDetail($request->file('imagePath'));

        // インスタンスをセッションへ
        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($request->input(), FormConstant::TEMP_TEAM_FORM_KEYS, $files);
        session(['temp_team_user' => $specifyFormRequestInputs]);

        // 画面用
        $values = $specifyFormRequestInputs->getAll();

        return view('tempTeamUsers.confirm', compact('values'));
    }

    /**
     * 完了
     *
     * @param Request $request
     * @return void
     */
    public function complete(Request $request)
    {
        $specifyFormRequestInputs = $request->session()->pull('temp_team_user');
        $customValues = $specifyFormRequestInputs->getAll();

        // 本登録済みかチェック
        if (User::checkIsRegistered($customValues['email'])) {
            return redirect()->route('tmp_team_user.index')
                ->withInput($customValues)
                ->withErrors(['email' => __('validation.unique')]);
        }

        // temp_usersモデルでDB登録とメール送信
        DB::transaction(function () use ($customValues) {
            $tempUserModel = new TempUser();
            $tempUserModel->registrationTempUser($customValues, $this->createUuid());
        });
        return view('tempTeamUsers.complete');
    }

    /**
     * SNS初回ログイン後、チームを作成フォーム
     *
     * @return void
     */
    public function teamCreate()
    {
        return view('teamRegister.team_index');
    }

    /**
     * SNS初回ログイン後、チームを作成確認画面
     *
     * @param TeamRegisterRequest $request
     * @return void
     */
    public function teamCreateConfirm(TeamRegisterRequest $request)
    {
        // アップロードされた画像のmime_typeとパスを取得
        $files = Images::getImageDetail($request->file('imagePath'));

        // インスタンスをセッションへ
        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($request->input(), FormConstant::REGISTER_TEAM_FORM_KEYS, $files);
        session(['temp_team_register' => $specifyFormRequestInputs]);

        // 画面用
        $values = $specifyFormRequestInputs->getAll();
        return view('teamRegister.team_confirm', compact('values'));
    }

    /**
     * チームを登録、チームメンバーとして登録後に、チームTOPへリダイレクト
     *
     * @param Request $request
     * @return void
     */
    public function teamCreateComplete(Request $request)
    {
        $specifyFormRequestInputs = session()->pull('temp_team_register');
        $values = $specifyFormRequestInputs->getAll();

        // チーム登録、チームメンバーを登録
        $teamId = DB::transaction(function () use ($values) {
            // チームへ登録
            $team = new Team();
            $teamId = $team->insertGetId([
                'sport_affiliation_type' => $values['sportAffiliationType'],
                'team_name' => $values['teamName'],
                'invitation_code' => $this->createUuid(),
                'prefecture' => $values['prefecture'],
                'address' => $values['address'],
                'team_url' => !empty($values['teamUrl']) ? $values['teamUrl'] : '',
                'image_path' => $values['imagePath'],
                'image_extension' => $values['imageExtension'],
            ]);

            $teamMember = new TeamMember();
            $teamMember->create([
                'user_id' => Auth::id(),
                'team_id' => $teamId,
            ]);

            return $teamId;
        });

        $team = Team::where('id', $teamId)->first();
        // チームトップへリダイレクトしセッションメッセージ表示
        $request->session()->flash('team.registered', $team->team_name . __('user_messages.success.team_registered'));

        return redirect()->route('team.index');
    }
}
