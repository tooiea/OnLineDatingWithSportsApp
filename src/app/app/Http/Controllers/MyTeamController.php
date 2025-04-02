<?php

namespace App\Http\Controllers;

use App\Enums\ConsentStatusTypeEnum;
use App\Models\ConsentGame;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MyTeamController extends Controller
{
    /**
     * チームトップ
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request): Response
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
        ])->with([
            'inviteStatuses' => [
                ConsentStatusTypeEnum::WAIT->value => ConsentStatusTypeEnum::WAIT->label(),
                ConsentStatusTypeEnum::ACCEPTED->value => ConsentStatusTypeEnum::ACCEPTED->label(),
                ConsentStatusTypeEnum::DECLINED->value => ConsentStatusTypeEnum::DECLINED->label(),
            ],
        ]);
    }

    /**
     * マイチーム詳細
     *
     * @return \Inertia\Response
     */
    public function detail(): Response
    {
        // ログイン中の所属チームを取得
        $myTeam = Team::getMyTeamByUserId(userId: Auth::id());

        return Inertia::render('MyTeam/TeamDetail', [
            'myTeam' => [
                'team' => [
                    'id' => $myTeam->id,
                    'name' => $myTeam->name,
                    'logo' => base64_encode(file_get_contents(Storage::path($myTeam->image->path))),
                    'extension' => $myTeam->image->extension,
                    'team_url' => $myTeam->url,
                    'code' => $myTeam->code->code,
                ],
            ],
            'teamMembersNumber' => $myTeam->team_members->count(),
        ]);
    }

    /**
     * マイチーム編集画面
     *
     * @return \Inertia\Response
     */
    public function edit(): Response
    {
        $userId = Auth::id();
        $team = Team::whereHas('team_members', function ($query) use ($userId) {
            $query->where('user_id', '=', $userId);
        })->with('album.image')->first();

        return Inertia::render('MyTeam/TeamEdit', [
            'team' => [
                'id' => $team->id,
                'name' => $team->name,
                'team_url' => $team->url,
                'image' => $team->image ? [
                    'id' => $team->image->id,
                    'path_base64' => $team->image->getPathBase64Attribute(),
                    'extension' => $team->image->extension,
                    'mime_type' => $team->image->mime_type,
                ] : null,
            ],
            'albumImages' => $team->album->flatMap(function ($album) {
                return collect($album->image)->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'path_base64' => $image->getPathBase64Attribute(),
                        'extension' => $image->extension,
                        'mime_type' => $image->mime_type,
                    ];
                });
            })->values(),
        ]);
    }

    public function update()
    {
        return Inertia::render('MyTeam/TeamEdit', [
            'myTeam' => Team::getMyTeamByUserId(userId: Auth::id()),
        ]);
    }
}
