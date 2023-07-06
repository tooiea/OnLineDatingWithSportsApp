<?php

namespace App\Http\Controllers;

use App\Enums\TeamAlbumTypeEnum;
use App\Http\Requests\TeamAlbumRequest;
use App\Models\ConsentGame;
use App\Models\Images;
use App\Models\Team;
use App\Models\TeamAlbum;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * チーム情報の取得
 */
class TeamsController extends BasesController
{
    /**
     * チームのトップに、招待状況を表示させる
     *
     * @return void
     */
    public function index()
    {
        $myTeam = TeamMember::getTeamByUserId(Auth::id());
        // チームを作らずに、直接ログインした場合
        if (empty($myTeam)) {
            return redirect()->route('tmp_sns_top.index');
        }
        $myTeamInvites = ConsentGame::getMyTeamInvites($myTeam->team->id);
        $asGuestInvites = ConsentGame::getAsGuestInvites($myTeam->team->id);

        return view('team.index', compact('myTeam', 'myTeamInvites', 'asGuestInvites'));
    }

    /**
     * チームの詳細ページ
     *
     * @return void
     */
    public function detail()
    {
        // ログイン中の所属チームを取得
        $myTeam = TeamMember::getTeamByUserId(Auth::id());

        // 所属しているチームの人数を取得
        $myTeamMembers = Team::where('id', '=', $myTeam->team->id)->with('teamMembers')->get();
        $teamMembersNumber = $myTeamMembers[0]->teamMembers->count();

        // アルバム取得
        $myTeamAlbums = TeamAlbum::query()->where('team_id', $myTeam->team->id)->get();
        return view('team.detail', compact('myTeam', 'teamMembersNumber', 'myTeamAlbums'));
    }

    /**
     * 編集画面表示
     *
     * @return void
     */
    public function edit(Request $request)
    {
        // ログイン中の所属チームを取得
        $myTeam = TeamMember::getTeamByUserId(Auth::id());

        $myTeamAlbums = TeamAlbum::query()->where('team_id', $myTeam->team->id)->get();

        return view('team.edit', compact('myTeam', 'myTeamAlbums'));
    }

    /**
     * チームプロフィールの更新
     *
     * @return void
     */
    public function update(TeamAlbumRequest $request)
    {
        Log::info($request->input('deleteAlbum'));

        DB::transaction(function () use ($request) {
            $teamId = TeamMember::query()->where(['user_id' => Auth::id()])->value('team_id');
            $team = Team::where('id', $teamId)->get()[0];
            $team->team_name = $request->input('teamName');
            $team->team_url = $request->input('teamUrl');

            // チームのロゴをアップロードされた
            if ($request->has('imagePath')) {
                // 画像削除(現行)
                Images::deleteImagefrom($team->image_path);

                // 新規で保存
                $image = Images::getImageDetail($request->file('imagePath'));

                // レコード物理削除
                $team->image_path = $image['imagePath'];
                $team->image_extension = $image['imageExtension'];
            }

            // 削除する画像が選択されたとき
            if ($request->has('deleteAlbum')) {
                foreach ($request->input('deleteAlbum') as $id) {
                    // チームアルバムとして画像を1枚ずつ登録
                    $imageId = Crypt::decryptString($id);
                    $image = TeamAlbum::query()->where(['id' => $imageId])->first();

                    // 画像削除
                    Images::deleteImagefrom($image->image_name);

                    // レコード物理削除
                    $image->delete();
                }
            }

            // 追加するアルバムがアップロードされたとき
            if ($request->has('teamAlbum')) {
                foreach ($request->file('teamAlbum') as $file) {
                    // 画像を保存する
                    $albumImage = Images::getAlbumImageDetail($file);

                    // チーム情報取得
                    $myTeam = TeamMember::getTeamByUserId(Auth::id());

                    // チームアルバムとして画像を1枚ずつ登録
                    $teamAlbum = new TeamAlbum();
                    $teamAlbum->team_id = $myTeam->team->id;
                    $teamAlbum->album_type = TeamAlbumTypeEnum::ALBUM->value;
                    $teamAlbum->image_name = $albumImage['imagePath'];
                    $teamAlbum->image_extension = $albumImage['imageExtension'];
                    $teamAlbum->save();
                }
            }
            $team->save();
        });

        return redirect()->route('team.detail');
    }
}
