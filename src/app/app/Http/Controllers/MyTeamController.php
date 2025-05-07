<?php
declare(strict_types=1);
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
        $myTeam = Team::whereRelation('team_members', 'user_id', '=', Auth::id())->firstOrFail();
        $myTeamInvites = ConsentGame::getMyTeamInvites($myTeam->id, $myTeam->sport_affiliation_type);
        $asGuestInvites = ConsentGame::getAsGuestInvites($myTeam->id, $myTeam->sport_affiliation_type);

        return Inertia::render('MyTeam/TeamInvitations', [
            'myTeamInvites' => $myTeamInvites,
            'asGuestInvites' => $asGuestInvites,
            'session' => $request->session()->all(),
            'inviteStatuses' => [
                ConsentStatusTypeEnum::WAIT->value => ConsentStatusTypeEnum::WAIT->label(),
                ConsentStatusTypeEnum::ACCEPTED->value => ConsentStatusTypeEnum::ACCEPTED->label(),
                ConsentStatusTypeEnum::DECLINED->value => ConsentStatusTypeEnum::DECLINED->label(),
            ],
            'message' => [
                'success' => session('flash_message'),
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
                    'prefectureLabel' => $myTeam->prefecture_code->label(),
                    'address' => $myTeam->address,
                    'favoriteFacility' => $myTeam->favorite_facility,
                    'logo' => base64_encode(file_get_contents(Storage::path($myTeam->image->path))),
                    'extension' => $myTeam->image->extension,
                    'team_url' => $myTeam->url,
                    'code' => $myTeam->code->code,
                ],
            ],
            'teamMembersNumber' => $myTeam->team_members->count(),
            'albums' => $myTeam->album->map(function ($album) {
                return [
                    'id' => $album->id,
                    'name' => $album->name,
                    'images' => collect($album->image)->map(function ($image) {
                        return [
                            'id' => $image->id,
                            'path_base64' => $image->path_base64,
                            'extension' => $image->extension,
                            'mime_type' => $image->mime_type,
                        ];
                    })->values(),
                ];
            })->values(),
            'message' => [
                'success' => session('flash_message'),
            ],
            'routes' => [
                'invite_url' => route('temp_register.team.join.index', ['invitation_code' => $myTeam->code->code]),
                'team_edit' => route('myteam.edit')
            ]
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
        $team = Team::whereRelation('team_members', 'user_id', '=', $userId)->with('album.image')->firstOrFail();

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
                    'path_base64' => $team->image->path_base64,
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
                            'path_base64' => $image->path_base64,
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
            'routes' => [
                'update' => route('myteam.update'),
            ]
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
            $team = Team::whereRelation('team_members', 'user_id', '=', Auth::id())->with('album.image')->firstOrFail();
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
            $albums = $request->input('albums') ?? [];
            foreach ($albums as $index => $albumData) {
                // アルバムの削除
                if ($albumData['isDelete']) {
                    $album = Album::find($albumData['id']);
                    if ($album) {
                        // アルバムの画像を削除
                        foreach ($album->image as $image) {
                            Storage::delete($image->path);
                            $image->delete();
                        }
                        $album->delete();
                    }
                } else {
                    // アルバムの登録、更新
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
            }
        });
        return redirect()->route('myteam.detail')->with([
            'flash_message' => 'チーム情報を更新しました。',
        ]);
    }
}
