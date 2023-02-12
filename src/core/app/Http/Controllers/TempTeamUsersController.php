<?php

namespace App\Http\Controllers;

use App\Constants\FormConstant;
use App\Http\Requests\TempTeamUserFormRequest;
use App\Models\TempUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
     * @param TempTeamUserFormRequest $request
     * @return void
     */
    public function confirm(TempTeamUserFormRequest $request)
    {
        $image = $request->file('teamLogo');
        $files = $this->getImageDetail($image);

        $specifyFormRequestInputs = new SpecifyFormRequestInputsController();
        $specifyFormRequestInputs->setAll($request->input(), FormConstant::TEMP_TEAM_FORM_KEYS, $files); // インスタンスをセッションへ
        session(['temp_team_user' => $specifyFormRequestInputs]);
        $values = $specifyFormRequestInputs->getAll();  // 画面用

        return view('tempTeamUsers.confirm', compact('values'));
    }

    /**
     *  画像からMIME TYPEとパスを取得
     *
     * @param object $image
     * @return array
     */
    private function getImageDetail($image)
    {
        $tempPath = $image->store('public/upload/images');
        $files['teamLogo'] = 'public/' . str_replace('public/', 'storage/', $tempPath);
        $files['image_extension'] = $image->getMimeType();

        return $files;
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
        if ($this->checkIsRegistered($customValues['email'])) {
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
