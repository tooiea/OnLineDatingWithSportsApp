<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchTeamController extends Controller
{
    private $teamMember;
    private $team;

    public function __construct(TeamMember $teamMember, Team $team)
    {
        $this->teamMember = $teamMember;
        $this->team = $team;
    }

    /**
     * ログイン後、自チームの登録住所(都道府県のチーム情報を表示)
     * 検索クエリを加えて、その検索結果を表示
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $values = $request->only(['prefecture', 'address']);
        $userId = Auth::user()->id;
        $myTeam = $this->teamMember->getTeamByUserId($userId);
        $teams = $this->team->getTeamBySearchQuery($myTeam, $values);

        return view('searchTeam.index', compact('teams'));
    }
}
