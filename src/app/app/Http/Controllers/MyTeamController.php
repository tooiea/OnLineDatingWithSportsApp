<?php

namespace App\Http\Controllers;

use App\Models\ConsentGame;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class MyTeamController extends Controller
{
    public function index(Request $request)
    {
        $myTeam = Team::whereHas('team_members', function ($query) {
            $query->where('user_id', '=', Auth::id());
        })->first();

        // チームを作らずに、直接ログインした場合
        if (empty($myTeam)) {
            // TODO チームに登録する処理から、チーム登録
        }

        $myTeamInvites = ConsentGame::getMyTeamInvites($myTeam->id);
        $asGuestInvites = ConsentGame::getAsGuestInvites($myTeam->id);

        return Inertia::render('MyTeam/TeamInvitations', [
            'myTeam' => $myTeam,
            'myTeamInvites' => $myTeamInvites,
            'asGuestInvites' => $asGuestInvites,
            'session' => $request->session()->all(),
        ]);
    }

    public function detail()
    {
        // ログイン中の所属チームを取得
        $myTeam = Team::whereHas('team_members', function ($query) {
            $query->where('user_id', '=', Auth::id());
        })->with('code')->first();

        // 所属しているチームの人数を取得
        $myTeamMembers = Team::where('id', '=', $myTeam->id)->with('team_members')->first();
        $teamMembersNumber = $myTeamMembers->team_members->count();
        return inertia('MyTeam/TeamDetail', [
            'myTeam' => [
                'team' => [
                    'id' => $myTeam->id,
                    'name' => $myTeam->name,
                    // 'logo' => base64_encode(file_get_contents($myTeam->team_logo)),
                    // 'image_extension' => $myTeam->image_extension,
                    'team_url' => $myTeam->url,
                    'code' => $myTeam->code->code,
                ],
            ],
            'teamMembersNumber' => $teamMembersNumber,
        ]);
    }
}
