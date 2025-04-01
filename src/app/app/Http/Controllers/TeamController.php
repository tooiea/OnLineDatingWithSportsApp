<?php

namespace App\Http\Controllers;

use App\Enums\Prefecture;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function create()
    {
        return view('team.create');
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
    public function list(Request $request): Response
    {
        $values = $request->only(['prefecture', 'address']);
        $prefecture = $request->input('prefecture') ?? null;
        $address = $request->input('address') ?? null;
        $teamName = $request->input('teamName') ?? null;

        // じぶんのチームを取得
        $myTeam = Team::getMyTeamByUserId(Auth::id());

        // チーム一覧取得
        $teams = Team::getOtherTeamsForPaginator(
            pageNum: 12,
            myTeam: $myTeam,
            prefecture: $prefecture,
            address: $address,
            teamName: $teamName
        );

        return Inertia::render('Team/SearchTeam', [
            'prefectures' => collect(Prefecture::cases())->map(fn($item) => [
                'value' => $item->value,
                'label' => $item->label(),
            ]),
            'teams' => $teams->through(fn($team) => [
                'id' => $team->id,
                'name' => $team->name,
                'address' => $team->address,
                'logo' => $team->image ? $team->image->path_base64 : null,
                'extension' => $team->image ? $team->image->mime_type : null,
                'code' => $team->code,
            ]),
            'filters' => compact('prefecture', 'address', 'teamName'),
            'myTeam' => $myTeam ?? null,
        ]);
    }

    public function inviteGame()
    {

    }
}
