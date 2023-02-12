<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Constants\ErrorMessagesConstant;
use App\Constants\FormConstant;
use App\Http\Requests\TempUserFormRequest;
use App\Http\Requests\TempUserInvitationCodeRequest;
use App\Http\Requests\UserFormRequest;
use App\Mail\TempUserSendMailer;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TempUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TempUsersController extends BasesController
{
    private $tempUser;
    private $user;

    public function __construct(TempUser $tempUser, User $user)
    {
        $this->user = $user;
        $this->tempUser = $tempUser;
    }

    /**
     * 仮登録フォーム
     *
     * @return void
     */
    public function index(TempUserInvitationCodeRequest $request, $invitation_code)
    {
        session(['temp_user_invitaion_code' => $invitation_code]);
        return view('tempUsers.index');
    }

    /**
     * 確認画面
     *
     * @param TempUserFormRequest $request
     * @return void
     */
    public function confirm(TempUserFormRequest $request)
    {
        $values['invitation_code'] = $request->session()->pull('temp_user_invitaion_code');
        $values = array_merge($values, $request->input());
        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($values, FormConstant::TEMP_FORM_KEYS); // インスタンスをセッションへ
        session(['temp_user' => $specifyFormRequestInputs]);

        $values = $specifyFormRequestInputs->getAll();  // 画面用

        return view('tempUsers.confirm', compact('values'));
    }

    /**
     * DB登録、メール送信
     *
     * @param  TempUserRequest $request
     * @return void
     */
    public function complete(Request $request)
    {
        $specifyFormRequestInputs = $request->session()->pull('temp_user');
        $customValues = $specifyFormRequestInputs->getAll();

        // 本登録済みかチェック
        if ($this->checkIsRegistered($customValues['email'])) {
            return redirect()->route('tmp_user.index')
                ->withInput($customValues)
                ->withErrors(['email' => __('validation.unique')]);
        }

        // トランザクション内で、DB登録とメール送信を実行
        DB::transaction(function () use ($customValues) {
            // temp_usersモデルでDB登録とメール送信
            $this->tempUser->registrationTempUserByInvitationCode($customValues, $this->createUuid());
        });
        return view('tempUsers.complete');
    }

    /**
     * 招待コードからチームコードを取得
     *
     * @param array $values
     * @return string
     */
    private function getTeamId($values)
    {
        $team = new Team();
        $teamId = '';

        if (isset($values['invitationCode'])) {
            $teamId = $team->getTeamIdByInvitationCode($values['invitationCode']);
        }

        return $teamId;
    }

    /**
     * 存在しないチーム招待コードでのアクセス
     *
     * @return void
     */
    public function failedInvitationCode()
    {
        return view('failed.invalid_invitation_code');
    }

    /**
     * 登録処理前にユーザが本登録されていないかをチェック
     *
     * @param string $customValues
     * @return boolean
     */
    private function checkIsRegistered($email)
    {
        $userModel = new User();
        $activatedUser = $userModel->getByEmail($email);
        $isRegistered = false;

        // 登録前に、同一メールアドレスが本登録されていないかをチェック
        if ($activatedUser) {
            $isRegistered = true;
        }
        return $isRegistered;
    }
}
