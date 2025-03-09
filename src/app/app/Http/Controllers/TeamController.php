<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function register()
    {
        return view('team.register');
    }

    /**
     * チーム一覧
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function list(Request $request) : \Illuminate\Contracts\View\View
    {
        $values = $request->only(['prefecture', 'address']);
        $prefecture = $request->input('prefecture') ?? null;
        $address = $request->input('address') ?? null;
        $myTeam = TeamMember::where('user_id', Auth::id())->first();
        $team = Team::query();

        // 都道府県
        if (!empty($prefecture)) {
            $team->where('prefecture_code', '=', $prefecture);
        } elseif (!empty($myTeam)) {
            $team->where('prefecture_code', '=', $myTeam->team->prefecture_code);
        }

        // 住所
        if (!empty($address)) {
            $team->where('address', 'like', '%' . $address . '%');
        }

        // 自チーム登録なし
        if (!is_null($myTeam)) {
            $team->where('id', '<>', $myTeam->team_id); // 自チームを除外
        }
        $teams = $team->with('code')->paginate(20);
        $prefecture ? $teams->appends(['prefecture_code' => $prefecture]) : null;
        $address ? $teams->appends(['address' => $address]) : null;
        return view('team.list', compact('teams', 'prefecture', 'address', 'myTeam'));
    }
}
