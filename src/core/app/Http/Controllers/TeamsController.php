<?php

namespace App\Http\Controllers;

use App\Models\ConsentGame;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamsController extends Controller
{
    private $consentGame;
    private $team;
    private $teamMember;

    /**
     * モデルのインスタンスを生成
     *
     * @param Team $team
     * @param TeamMember $teamMember
     */
    public function __construct(ConsentGame $consentGame, Team $team, TeamMember $teamMember)
    {
        $this->consentGame = $consentGame;
        $this->team = $team;
        $this->teamMember = $teamMember;
    }

    /**
     * チームのトップに、招待状況を表示させる
     *
     * @return void
     */
    public function index()
    {
        $myTeam = $this->getMyTeam();
        // チームを作らずに、直接ログインした場合
        if (empty($myTeam)) {
            // TODO チームに登録する処理から、チーム登録
        }
        $myTeamInvites = $this->consentGame->getMyTeamInvites($myTeam->id);
        $asGuestInvites = $this->consentGame->getAsGuestInvites($myTeam->id);

        return view('team.index', compact('myTeam', 'myTeamInvites', 'asGuestInvites'));
    }

    /**
     * チームの詳細ページ
     *
     * @return void
     */
    public function detail()
    {
        $myTeam = $this->getMyTeam();
        $myTeamMembers = $this->teamMember->getTeamMembers(Auth::id());
        $teamMembersNumber = $myTeamMembers->count();
        return view('team.detail', compact('myTeam', 'teamMembersNumber'));
    }

    /**
     * ログインユーザの所属しているチーム情報を取得する
     *
     * @return object
     */
    private function getMyTeam()
    {
        $myTeam = $this->teamMember->getTeamByUserId(Auth::id());
        return $myTeam;
    }
}
