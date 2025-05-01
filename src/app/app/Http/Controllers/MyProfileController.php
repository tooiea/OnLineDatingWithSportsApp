<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Enums\SportAffiliationTypeEnum;
use App\Http\Requests\MyProfileRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MyProfileController extends Controller
{
    /**
     * マイプロフィール詳細画面
     *
     * @return \Inertia\Response
     */
    public function detail(): Response
    {
        $user = User::with(['teamMember.team', 'image'])->find(Auth::id());
        $sportType = $user->teamMember->team->sport_affiliation_type;
        return Inertia::render('Profile/Detail', [
            'nickname' => $user->name,
            'positionLabel' => $user->teamMember->position ? $sportType->positionFrom($user->teamMember->position) : null,
            'handednessLabel' => $user->teamMember->handedness ? $sportType->handednessFrom($user->teamMember->handedness) : null,
            'imagePath' => $user->image?->path_base64,
            'message' => [
                'success' => session('flash_message'),
            ],
            'routes' => [
                'edit' => route('my-profile.edit')
            ]
        ]);
    }

    /**
     * マイプロフィール編集画面
     *
     * @return \Inertia\Response
     */
    public function edit(): Response
    {
        $user = User::with(['teamMember.team', 'image'])->find(Auth::id());
        $positionOptions = [];
        $handednessOptions = [];

        // 所属しているチーム種別よりリストを取得
        foreach (SportAffiliationTypeEnum::cases() as $sport) {
            if ($sport->value === $user->teamMember->team->sport_affiliation_type->value) {
                $positionOptions = $sport->positions();
                $handednessOptions = $sport->handedness();
            }
        }

        return Inertia::render('Profile/Edit', [
            'positionOptions' => $positionOptions,
            'handednessOptions' => $handednessOptions,
            'userProfile' => [
                'nickname' => $user->name,
                'position' => $user->teamMember->position,
                'handedness' => $user->teamMember->handedness,
                'image_path' => $user->image?->path_base64,
            ],
            'routes' => [
                'update' => route('my-profile.update'),
            ]
        ]);
    }

    /**
     * マイプロフィール更新
     *
     * @param MyProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MyProfileRequest $request): RedirectResponse
    {
        $user = User::with(['teamMember.team', 'image'])->find(Auth::id());
        DB::transaction(function () use ($request, $user){
            $user->name = $request->validated('nickname');
            $user->save();

            $user->teamMember->position = $request->validated('position');
            $user->teamMember->handedness = $request->validated('handedness');
            $user->teamMember->save();

            // 画像のみ削除
            if ($request->boolean('deleteImage') && ! empty($user->image->path)) {
                Storage::delete($user->image->path);
                $user->image()->delete();
            }

            // 画像を登録
            if ($request->file('image')) {
                $user->image()->create([
                    'path' => Storage::putFile(User::MYPROFILE_IMAGE_PATH, $request->file('image')),
                    'extension' => $request->file('image')->extension(),
                    'mime_type' => $request->file('image')->getMimeType(),
                ]);
            }
        });
        return redirect()->route('my-profile.detail')->with([
            'flash_message' => 'マイプロフィールを更新しました。',
        ]);
    }
}
