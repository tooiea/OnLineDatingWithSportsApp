<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\UserFormRequest;
use App\Http\Requests\UserTokenRequest;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TempUser;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * ユーザ本登録
 */
class UsersController extends BasesController
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
                $tempUser = TempUser::getUserByToken($token);

                // 新規ユーザとして登録
                $userModel = new User();
                $userId = $userModel->registerUser($tempUser);

                // 存在するチームへ登録
                if (empty($tempUser->sport_affiliation_type)) {
                    // チーム特定(チームに招待されたユーザ)
                    $invitationCode = $tempUser->invitation_code;
                    $teamId = Team::getTeamIdByInvitationCode($invitationCode);
                } else {
                    // チームを新規で登録
                    $invitationCode = $this->createUuid(); // 招待コード取得
                    $teamModel = new Team();
                    $teamId = $teamModel->registerTeam($tempUser, $invitationCode);
                }

                // チームメンバーに登録
                $teamMemberModel = new TeamMember();
                $teamMember = $teamMemberModel->create([
                    'user_id' => $userId,
                    'team_id' => $teamId,
                ]);

                // 仮ユーザから削除
                $tempUserModel = new TempUser();
                $tempUserModel->where('email', '=', $tempUser->email)->delete();

                // メール送信
                $user = TeamMember::getUserByTeamIdAndUserId($teamMember);
                $userModel->registrationNotification($user);
             });
        } catch (Exception $e) {
            Log::error($e);
            $request->session()->flash('user.register.error', __('validation.custom.error.register'));
            return redirect()->route('login.index');
        }
        $request->session()->flash('user.registered', __('user_messages.success.registered'));

        return redirect()->route('login.index');
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
