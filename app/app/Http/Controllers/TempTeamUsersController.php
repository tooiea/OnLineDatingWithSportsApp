<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Http\Requests\TempTeamUserFormRequest;
use App\Models\Images;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Http\Request;
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
}
