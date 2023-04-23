<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Http\Requests\InvitationCodeRequest;
use App\Http\Requests\TempUserFormRequest;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 仮ユーザ登録(チームに招待の場合)
 */
class TempUsersController extends BasesController
{
    /**
     * 仮登録フォーム
     *
     * @return void
     */
    public function index(InvitationCodeRequest $request, $invitation_code)
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
        if (User::checkIsRegistered($customValues['email'])) {
            return redirect()->route('tmp_user.index')
                ->withInput($customValues)
                ->withErrors(['email' => __('validation.unique')]);
        }

        // トランザクション内で、DB登録とメール送信を実行
        DB::transaction(function () use ($customValues) {
            // temp_usersモデルでDB登録とメール送信
            $tempUserModel = new TempUser();
            $tempUserModel->registrationTempUserByInvitationCode($customValues, $this->createUuid());
        });
        return view('tempUsers.complete');
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
}
