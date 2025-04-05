<?php

namespace App\Http\Controllers;

use App\Enums\ConsentStatusTypeEnum;
use App\Enums\Prefecture;
use App\Http\Requests\MyTeamEditRequest;
use App\Models\Album;
use App\Models\ConsentGame;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'message' => [
                'success' => session('flash_message'),
            ],
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
                'prefecture' => $team->prefecture_code,
                'address' => $team->address,
                'favoriteFacility' => $team->favorite_facility,
                'image' => $team->image ? [
                    'id' => $team->image->id,
                    'path_base64' => $team->image->getPathBase64Attribute(),
                    'extension' => $team->image->extension,
                    'mime_type' => $team->image->mime_type,
                ] : null,
            ],
            'albums' => $team->album->map(function ($album) {
                return [
                    'id' => $album->id,
                    'name' => $album->name,
                    'images' => collect($album->image)->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'path_base64' => $image->getPathBase64Attribute(),
                            'extension' => $image->extension,
                            'mime_type' => $image->mime_type,
                        ];
                    })->values(),
                ];
            })->values(),
            'prefectures' => collect(Prefecture::cases())->map(fn($item) => [
                'value' => $item->value,
                'label' => $item->label(),
            ]),
        ]);
    }

    /**
     * チーム情報更新処理
     *
     * @param MyTeamEditRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MyTeamEditRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            // チーム情報更新
            $team = Team::whereHas('team_members', function ($query) {
                $query->where('user_id', '=', Auth::id());
            })->with('album.image')->first();
            $team->name = $request->input('teamName');
            $team->prefecture_code = $request->input('prefecture');
            $team->address = $request->input('address');
            $team->favorite_facility = $request->input('favoriteFacility');
            $team->url = $request->input('teamUrl');
            $team->save();

            // メイン画像の更新
            if ($request->hasFile('teamMainImage')) {
                // すでにファイルが存在する場合は画像削除
                if ($team->image) {
                    Storage::delete($team->image->path);
                }

                // 現在のレコードがあれば更新、なければ新規登録
                $team->image()->updateOrCreate(
                    ['imageable_id' => $team->id, 'imageable_type' => Team::class],
                    [
                        'path' => Storage::putFile(Team::MAIN_IMAGE_PATH, $request->file('teamMainImage')),
                        'extension' => $request->file('teamMainImage')->extension(),
                        'mime_type' => $request->file('teamMainImage')->getMimeType(),
                    ]
                );
            }

            // アルバム登録、更新
            foreach ($request->input('albums') as $index => $albumData) {
                $albumId = $albumData['id'] ?? null;
                $album = Album::find($albumId)?? new Album([
                    'albumable_type' => Team::class,
                    'albumable_id' => $team->id,
                ]);
                $album->name = $albumData['name'];
                $album->save();

                // アルバムの画像を削除
                $deleteImages = $albumData['deleteImages'] ?? [];
                foreach ($deleteImages as $image) {
                    $albumImage = $album->image()->find($image);
                    if ($albumImage) {
                        Storage::delete($albumImage->path);
                        $albumImage->delete();
                    }
                }

                // アルバムの画像を登録
                $addImages = $request->file("albums.{$index}.addImages") ?? [];
                foreach ($addImages as $image) {
                    $album->image()->create([
                        'path' => Storage::putFile(Team::ALBUM_IMAGE_PATH, $image),
                        'extension' => $image->extension(),
                        'mime_type' => $image->getMimeType(),
                    ]);
                }
            }
        });
        return redirect()->route('myteam.detail')->with([
            'flash_message' => 'チーム情報を更新しました。',
        ]);
    }
}
