<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Http\Requests\TempUserRequest;
use App\Http\Requests\UserFormRequest;
use App\Mail\TempUserSendMailer;
use App\Models\TempUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $expireDate = $now->addHour();
                $tempUser = new TempUser();
                $values['token'] = $this->createUuid();
                $tempUser->insert(
                    [
                        'email' => $values['email'],
                        'token' => $values['token'],
                        'expiration_date' => $now,
                    ]
                );
                Mail::to($values['email'])->send(new TempUserSendMailer($values['token']));
            }
        );

        return view('tempUsers.complete');
    }
}
