<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationCodeRequest;
use App\Http\Requests\TempTeamJoinRequest;
use App\Models\Code;
use App\Models\TempTeamJoinRegister;
use App\Models\TempUser;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TempTeamJoinController extends Controller
{
    /**
     * 初期表示
     *
     * @param string $invitation_code
     * @return \Inertia\Response
     */
    public function index(InvitationCodeRequest $request, string $invitation_code): Response
    {
        return Inertia::render('Register/TeamJoinRegistrationForm', [
            'invitation_code' => $invitation_code,
            'old' => session()->getOldInput(),
        ]);
    }

    /**
     * 確認画面
     *
     * @param TempTeamJoinRequest $request
     * @param string $invitation_code
     * @return \Inertia\Response
     */
    public function confirm(TempTeamJoinRequest $request, string $invitation_code): Response
    {
        // セッションへ保存
        session(['temp_team_register.form' => new TempTeamJoinRegister(
            nickname: $request->validated('nickname'),
            email: $request->validated('email'),
            password: $request->validated('password'),
        )]);
        return Inertia::render('Register/TeamJoinRegistrationConfirm', [
            'nickname' => $request->validated('nickname'),
            'email' => $request->validated('email'),
            'invitation_code' => $invitation_code,
        ]);
    }

    /**
     * 確認画面から入力画面へ戻り
     *
     * @param InvitationCodeRequest $request
     * @param string $invitation_code
     * @return RedirectResponse
     */
    public function back(InvitationCodeRequest $request, string $invitation_code): RedirectResponse
    {
        // セッションから取得
        $form = $request->session()->pull('temp_team_register.form');

        if (is_null($form)) {
            // セッションに値がない場合、初期ページへリダイレクト
            return redirect()->route('temp_register.team.index');
        }
        $tempTeamRegister = $form->getAll();
        return redirect()->route('temp_register.team.join.index', ['invitation_code' => $invitation_code])->withInput($tempTeamRegister);
    }

    /**
     * 登録完了画面
     *
     * @param Request $request
     * @param string $invitation_code
     * @return \Inertia\Response
     */
    public function complete(InvitationCodeRequest $request, string $invitation_code): RedirectResponse | Response
    {
        // セッションから取得
        $tempTeamRegister = $request->session()->pull('temp_team_register.form');

        if (is_null($tempTeamRegister)) {
            // セッションに値がない場合、初期ページへリダイレクト
            return redirect()->route('temp_register.team.index');
        }

        // DB登録とメール送信を実行
        DB::transaction(function () use ($tempTeamRegister, $invitation_code) {
            // temp_usersモデルでDB登録とメール送信
            $tempUser = new TempUser();
            $tempUser->nickname = $tempTeamRegister->nickname;
            $tempUser->email = $tempTeamRegister->email;
            $tempUser->password = Hash::make($tempTeamRegister->password);
            $tempUser->invitation_code = $invitation_code;
            $tempUser->save();
            $uuid = Str::uuid();

            // 本登録用の認証コード
            $tempUser->code()->save(new Code([
                'code' => $uuid,
                'expired_at' => Carbon::now()->addHour()
            ]));
            $tempUser->temporaryRegistrationNotification($uuid, config('mail.from.address'));
        });
        return Inertia::render('Register/TeamRegistrationComplete');
    }

    /**
     * 不正な招待コード
     *
     * @return \Inertia\Response
     */
    public function invalid(): Response
    {
        // 招待コードが無効な場合
        return Inertia::render('Errors/500', [
            'message' => '招待コードが無効です。',
        ]);
    }
}
