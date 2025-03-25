<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserTokenRequest;
use App\Models\Code;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TempUser;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * 本登録
     *
     * @param UserTokenRequest $request
     * @param string $token
     * @return void
     */
    public function index(UserTokenRequest $request, $token)
    {
        try {
             DB::transaction(function () use ($token) {
                // URLのトークンから仮ユーザを取得
                $tempUser = TempUser::where('token', $token)->first();

                // 新規登録
                $user = new User();
                $user->name = $tempUser->nickname;
                $user->email = $tempUser->email;
                $user->password = $tempUser->email;
                $user->last_login_at = CarbonImmutable::now();
                $user->save();

                // 存在するチームへ登録
                if (! empty($tempUser->code()->code)) {
                    $team = Team::whereRelation('code', 'code', $tempUser->invitation_code)->first();
                } else {
                    // 新規チーム登録
                    $team = new Team();
                    $team->name = $tempUser->team_name;
                    $team->sport_affiliation_type = $tempUser->sport_affiliation_type;
                    $team->prefecture_code = $tempUser->prefecture_code;
                    $team->address = $tempUser->address;
                    $team->url = $tempUser->team_url;
                    $team->save();

                    // チームの招待用コードを生成
                    $team->code()->save(new Code([
                        'codeable_type' => Team::class,
                        'codeable_id' => $team->id,
                        'code' => Str::uuid(),
                        'expired_at' => Carbon::now()->addYear()
                    ]));
                }

                // チームメンバー登録
                $teamMember = new TeamMember();
                $teamMember->user_id = $user->id;
                $teamMember->team_id = $team->id;
                $teamMember->save();

                // 仮ユーザ削除
                TempUser::where('email', $tempUser->email)->delete();

                // メール送信
                $user->registrationNotification([
                    'name' => $user->name,
                    'teamName' => $team->name,
                    'admin' => config('mail.from.address')
                ]);
             });
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('email_login.index')->with('status', __('messages.failed.registered'));
        }
        return redirect()->route('email_login.index')->with('status', __('messages.success.registered'));
    }

    /**
     * トークンチェック後のエラー画面
     *
     * @return void
     */
    public function failedToken()
    {
        return view('failed.lost_token');
    }

    public function errorRegister()
    {
        return view('failed.error');
    }
}
