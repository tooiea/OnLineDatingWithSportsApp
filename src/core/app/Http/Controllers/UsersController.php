<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
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

class UsersController extends BasesController
{
    private $userModel;
    private $tempUserModel;
    private $teamModel;
    private $teamMemberModel;

    public function __construct(
        User $userModel,
        TempUser $tempUserModel,
        Team $teamModel,
        TeamMember $teamMemberModel
    ) {
        $this->userModel = $userModel;
        $this->tempUserModel = $tempUserModel;
        $this->teamModel = $teamModel;
        $this->teamMemberModel = $teamMemberModel;
    }
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
            DB::beginTransaction();
            $tempUser = $this->tempUserModel->getUserByToken($token);
            $userId = $this->userModel->registerUser($tempUser);

            // チーム招待での登録
            if (empty($tempUser->sport_affiliation_type)) {
                // チーム特定
                $invitationCode = $tempUser->invitation_code;
                $teamId = $this->teamModel->getTeamIdByInvitationCode($invitationCode);
            } else {
                // チームを登録
                $invitationCode = $this->createUuid();
                $teamId = $this->teamModel->registerTeam($tempUser, $invitationCode);
            }

            $teamMember = $this->teamMemberModel->registerTeamMember($userId, $teamId);
            $this->tempUserModel->deleteTempUserData($tempUser);

            // メール送信
            $user = $this->teamMemberModel->getUserByTeamIdAndUserId($teamMember);
            $this->userModel->registrationNotification($user);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
