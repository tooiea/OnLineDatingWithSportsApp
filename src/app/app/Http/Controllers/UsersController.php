<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\UserTokenRequest;
use App\Models\Code;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TempUser;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * 本登録
     *
     * @param UserTokenRequest $request
     * @param string $token
     * @return RedirectResponse
     */
    public function index(UserTokenRequest $request, string $token): RedirectResponse
    {
        try {
             DB::transaction(function () use ($token) {
                // URLのトークンから仮ユーザを取得
                $tempUser = TempUser::whereRelation('code', 'code', $token)->first();

                // 新規登録
                $user = new User();
                $user->name = $tempUser->nickname;
                $user->email = $tempUser->email;
                $user->password = $tempUser->password;
                $user->last_login_at = CarbonImmutable::now();
                $user->save();

                // 存在するチームへ登録
                if (! empty($tempUser->invitation_code)) {
                    $team = Team::whereRelation('code', 'code', $tempUser->invitation_code)->first();
                } else {
                    // 新規チーム登録
                    $team = new Team();
                    $team->name = $tempUser->team_name;
                    $team->sport_affiliation_type = $tempUser->sport_affiliation_type;
                    $team->prefecture_code = $tempUser->prefecture_code;
                    $team->address = $tempUser->address;
                    $team->url = $tempUser->team_url;
                    $team->save();

                    // チームの招待用コードを生成
                    $team->code()->save(new Code([
                        'code' => Str::uuid(),
                        'expired_at' => Carbon::now()->addYear()
                    ]));

                    // 仮ユーザの画像をチームの画像として移動
                    Storage::move($tempUser->image->path, Team::MAIN_IMAGE_PATH . '/' . basename($tempUser->image->path));
                    $team->image()->create([
                        'imageable_id' => $team->id,
                        'imageable_type' => 'team',
                        'path'  => Team::MAIN_IMAGE_PATH . '/' . basename($tempUser->image->path),
                        'extension' => $tempUser->image->extension,
                        'mime_type' => $tempUser->image->mime_type,
                    ]);

                    // 画像移動後に削除
                    $tempUser->image()->delete();
                }

                // チームメンバー登録
                $teamMember = new TeamMember();
                $teamMember->user_id = $user->id;
                $teamMember->team_id = $team->id;
                $teamMember->save();

                // 仮ユーザ削除
                TempUser::where('email', $tempUser->email)->delete();

                // メール送信
                $user->registrationNotification([
                    'name' => $user->name,
                    'teamName' => $team->name,
                    'admin' => config('mail.from.address')
                ]);
             });
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('login.index')->with('status', __('messages.failed.registered'));
        }
        return redirect()->route('login.index')->with('status', __('messages.success.registered'));
    }

    /**
     * エラー画面
     *
     * @return \Inertia\Response
     */
    public function failedToken()
    {
        return Inertia::render('Errors/500', [
            'message' => __('messages.failed.token'),
        ]);
    }

    /**
     * エラー画面
     *
     * @return \Inertia\Response
     */
    public function error()
    {
        return Inertia::render('Errors/500', [
            'message' => __('messages.failed.token'),
        ]);
    }
}
