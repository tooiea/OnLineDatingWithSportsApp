<?php

namespace App\Http\Controllers;

use App\Http\Requests\TempUserRequest;
use App\Mail\TempUserSendMailer;
use App\Models\TempUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    /**
     * DB登録、メール送信
     *
     * @param  TempUserRequest $request
     * @return void
     */
    public function complete(TempUserRequest $request)
    {
        $values['email'] = $request->input('email');

        // トランザクション内で、DB登録とメール送信を実行
        DB::transaction(
            function () use ($values) {
                $now = Carbon::now();
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
