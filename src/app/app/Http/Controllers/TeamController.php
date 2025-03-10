<?php

namespace App\Http\Controllers;

use App\Enums\Prefecture;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TeamController extends Controller
{
    public function register()
    {
        return view('team.register');
    }

    public function index()
    {
        return Inertia::render('Team/Index');
    }

    /**
     * チーム一覧
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function list(Request $request)
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
        return Inertia::render('Team/SearchTeam', [
            'prefectures' => collect(Prefecture::cases())->map(fn($item) => [
                'value' => $item->value,
                'label' => $item->label(),
            ]),
            'teams' => $teams,
            'filters' => compact('prefecture', 'address'),
            'myTeam' => $myTeam ?? null,
        ]);
    }

    public function inviteGame()
    {

    }
}
