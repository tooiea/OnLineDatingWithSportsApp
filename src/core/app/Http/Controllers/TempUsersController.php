<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Constants\ErrorMessagesConstant;
use App\Http\Requests\TempUserRequest;
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
    /**
     * 仮登録フォーム
     *
     * @return void
     */
    public function index()
    {
        return view('tempUsers.index');
    }

    public function confirm(UserFormRequest $request)
    {
        // 必要情報のみをセット
        foreach (CommonConstant::USER_FORM_DATA as $key) {
            if (!is_null($request->input($key))) {
                $values[$key] = $request->input($key); // 表示用
            }
        }
        session($values); // セッションに保存

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
        $values = $request ->session()->all();
        $button = $request->input();
        // $request->session()->flush();
        $user = new User();
        $activatedUser = $user->getByEmail($values['email']);

        // 登録前に、同一メールアドレスが有効化されていないかをチェック
        if (!is_null($activatedUser)) {
            return redirect()->route('tmp_user.index')
                ->withInput($values)
                ->withErrors(['email' => ErrorMessagesConstant::ALREADY_REGISTERED]);
        }

        // フォームへ遷移
        if (isset($button['back'])) {
            // 戻るボタン
            return redirect()->route('tmp_user.index')->withInput($values);
        }

        // 完了処理
        if (isset($button['next'])) {
            // 送信するボタン
            // トランザクション内で、DB登録とメール送信を実行
            DB::transaction(
                function () use ($values, $user) {
                    $now = Carbon::now();
                    $values['expireDate'] = $now->addHour();
                    $tempUser = new TempUser();
                    $token = $this->createUuid();
                    $teamId = $this->getTeamId($values);

                    // temp_usersテーブルへ登録
                    $tempUser->updateOrCreate(
                        // 同一メールアドレスが存在するか
                        ['email' => $values['email']],
                        [
                            // 挿入データ
                            'email' => $values['email'],
                            'token' => $token,
                            'expiration_date' => $values['expireDate'],
                        ]
                    );

                    // usersテーブルへ登録
                    $registeredUser = $user->updateOrCreate(
                        // 同一メールアドレスが存在するか
                        ['email' => $values['email']],
                        [
                            // 挿入データ
                            'name1' => $values['name1'],
                            'name2' => $values['name2'],
                            'ruby1' => $values['ruby1'],
                            'ruby2' => $values['ruby2'],
                            'birthday' => $values['birthday'],
                            'email' => $values['email'],
                            'password' => Hash::make($values['password']),
                            'expiration_date' => $values['expireDate']
                        ],
                    );

                    // 招待コードが入力されている場合
                    if (!empty($teamId)) {
                        // team_membersテーブルへ登録
                        $teamMember = new TeamMember();
                        $teamMember->updateOrCreate(
                            ['user_id' => $registeredUser->id],
                            [
                                'team_id' => $teamId->id,
                                'user_id' => $registeredUser->id,
                            ]
                        );
                    }

                    Mail::to($values['email'])->send(new TempUserSendMailer($token));
                }
            );
        } else {
            // 不正アクセス
            return redirect()->route('tmp_user.index');
        }
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
}
