<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Http\Requests\TempTeamUserRequest;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
     *
     * @param TempTeamUserRequest $request
     * @return void
     */
    public function confirm(TempTeamUserRequest $request)
    {
        $image = $request->file('teamLogo');
        $tempPath = $image->store('public/upload/images');
        $filePath = 'public/' . str_replace('public/', 'storage/', $tempPath);
        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($request->input(), FormConstant::TEMP_TEAM_FORM_KEYS, ['teamLogo' => $filePath]); // インスタンスをセッションへ
        session(['temp_team_users' => $specifyFormRequestInputs]);

        $values = $specifyFormRequestInputs->getAll();  // 画面用

        // FIXME base64で表示
        // $values['img'] = 'data:' . $image->getMimeType() . ';base64,' . base64_encode(asset($values['teamLogo']));
        // var_dump($values['img']);

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
        $specifyFormRequestInputs = $request->session()->pull('temp_team_users');
        $customValues = $specifyFormRequestInputs->getAll();

        // 本登録済みかチェック
        if ($this->checkIsRegistered($customValues['email'])) {
            return redirect()->route('tmp_user.index')
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
