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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        DB::transaction(function () use ($token) {
            $tempUser = $this->tempUserModel->getUserByToken($token);
            $userId = $this->userModel->registerUser($tempUser);
            $invitationCode = $this->createUuid();
            $teamId = $this->teamModel->registerTeam($tempUser, $invitationCode);
            $teamMember = $this->teamMemberModel->registerTeamMember($userId, $teamId);
            $this->tempUserModel->deleteTempUserData($tempUser);

            // メール送信
            $user = $this->teamMemberModel->getUserByTeamIdAndUserId($teamMember);
            $this->userModel->registrationNotification($user);
        });

        // TODO 登録完了後のセッションメッセージをセット

        return redirect()->route('login.index');
    }
}
