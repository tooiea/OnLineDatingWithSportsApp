<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Enums\Prefecture;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    /**
     * ユーザ登録後、チーム登録がない場合
     * チーム作成 or チームへ加入する選択する画面
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Register/TeamRegistrationSelect',[
            'routes' => [
                'team_index' => route('register.team.index'),
                'team_join_index' => route('register.team.join.index'),
            ]
        ]);
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
            prefecture: (int)$prefecture,
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
                'routes' => [
                    'invite' => route('team.invite_game.index', $team->id),
                ]
            ]),
            'filters' => compact('prefecture', 'address', 'teamName'),
            'myTeam' => $myTeam ?? null,
            'routes' => [
                'team_list' => route('team.list'),
            ]
        ]);
    }
}
