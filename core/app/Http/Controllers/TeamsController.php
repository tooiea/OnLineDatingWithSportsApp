<?php

namespace App\Http\Controllers;

use App\Models\ConsentGame;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * チーム情報の取得
 */
class TeamsController extends Controller
{
    /**
     * チームのトップに、招待状況を表示させる
     *
     * @return void
     */
    public function index()
    {
        $myTeam = TeamMember::getTeamByUserId(Auth::id());
        // チームを作らずに、直接ログインした場合
        if (empty($myTeam)) {
            // TODO チームに登録する処理から、チーム登録
        }
        $myTeamInvites = ConsentGame::getMyTeamInvites($myTeam->id);
        $asGuestInvites = ConsentGame::getAsGuestInvites($myTeam->id);

        return view('team.index', compact('myTeam', 'myTeamInvites', 'asGuestInvites'));
    }

    /**
     * チームの詳細ページ
     *
     * @return void
     */
    public function detail()
    {
        // ログイン中の所属チームを取得
        $userId = Auth::id();
        $myTeam = TeamMember::getTeamByUserId($userId);

        // 所属しているチームの人数を取得
        $myTeamMembers = Team::where('id', '=', $myTeam->team_id)->with('teamMembers')->get();
        $teamMembersNumber = $myTeamMembers[0]->teamMembers->count();
        return view('team.detail', compact('myTeam', 'teamMembersNumber'));
    }
}