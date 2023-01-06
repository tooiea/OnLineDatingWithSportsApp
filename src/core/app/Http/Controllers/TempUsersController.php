<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Http\Requests\TempUserRequest;
use App\Http\Requests\UserFormRequest;
use App\Mail\TempUserSendMailer;
use App\Models\TempUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        // TODO ユーザ情報を入力するように変更
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

        // TODO 仮登録として、Usersテーブルに登録し、仮登録フラグをテーブルのカラムに追加

        // トランザクション内で、DB登録とメール送信を実行
        DB::transaction(
            function () use ($values) {
                $now = Carbon::now();
                $values['expireDate'] = $now->addHour();
                $tempUser = new TempUser();
                $token = $this->createUuid();
                $tempUser->updateOrInsert(
                    [
                        // 同一メールアドレスが存在するか
                        'email' => $values['email'],
                    ],
                    [
                        // 挿入データ
                        'email' => $values['email'],
                        'token' => $token,
                        'expiration_date' => $values['expireDate'],
                    ]
                );
                $user = new User();
                $user->updateOrInsert(
                    [
                        // 同一メールアドレスが存在するか
                        'email' => $values['email'],
                    ],
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
                Mail::to($values['email'])->send(new TempUserSendMailer($token));
            }
        );
        $request->session()->flush();

        return view('tempUsers.complete');
    }
}
