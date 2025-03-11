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

        // じぶんのチームを取得
        $myTeam = Team::whereHas('team_members', function ($query) {
            $query->where('user_id', '=', Auth::id());
        })->first();

        // チーム一覧取得
        $team = Team::query();

        // 検索条件
        $prefecture ? $team->where('prefecture_code', '=', $prefecture) : null;
        $address ? $team->where('address', 'like', '%' . $address . '%') : null;

        // 自チームを除外
        $myTeam ? $team->where('id', '<>', $myTeam->id) : null;
        $teams = $team->with('code')->paginate(20);

        // ページネーションのクエリパラメータを設定
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
