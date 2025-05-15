<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Enums\Prefecture;
use App\Enums\SportAffiliationTypeEnum;
use App\Http\Requests\TeamRegisterRequest;
use App\Models\Code;
use App\Models\Image;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\TeamRegister;
use App\Models\TempFile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TeamRegisterController extends Controller
{
    /**
     * 入力画面
     * 確認画面からの戻り
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Register/TeamRegistrationForm', [
            'prefectures' => Prefecture::list(),
            'sports' => SportAffiliationTypeEnum::list(),
            'old' => session()->getOldInput(),
            'routes' => [
                'confirm' => route('register.team.confirm'),
                'select' => route('register.team.select'),
            ]
        ]);
    }

    /**
     * 確認画面
     *
     * @param TeamRegisterRequest $request
     * @return \Inertia\Response
     */
    public function confirm(TeamRegisterRequest $request): Response
    {
        $tempFile = new TempFile($request->file('teamLogo'));
        $teamRegister = new TeamRegister(
            sportAffiliationType: (int)$request->validated('sportAffiliationType'),
            teamName: $request->validated('teamName'),
            tempFile: $tempFile,
            teamUrl: $request->validated('teamUrl'),
            prefecture: (int)$request->validated('prefecture'),
            address: $request->validated('address'),
        );

        session(['team_register.form' => $teamRegister]);
        return Inertia::render('Register/TeamRegistrationConfirm', [
            'sportAffiliationLabel' => SportAffiliationTypeEnum::from((int)$request->validated('sportAffiliationType'))->label(),
            'teamName' => $request->validated('teamName'),
            'teamUrl' => $request->validated('teamUrl'),
            'prefectureLabel' => Prefecture::from((int)$request->validated('prefecture'))->label(),
            'address' => $request->validated('address'),
            'teamLogoUrl' => $tempFile->pathFromBase64(),
            'routes' => [
                'complete' => route('register.team.complete'),
                'back' => route('register.team.back')
            ]
        ]);
    }

    /**
     * 確認画面から入力画面へ戻り
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back(Request $request): RedirectResponse
    {
        $teamRegister = $request->session()->pull('team_register.form');
        $values = $teamRegister? $teamRegister->getAll() : null;
        $tempFile = $teamRegister->tempFile;
        $tempFile->delete();
        return redirect()->route('register.team.index')->withInput($values);
    }

    /**
     * 完了処理
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request): RedirectResponse
    {
        $teamRegister = $request->session()->pull('team_register.form');

        if (is_null($teamRegister)) {
            // セッションに値がない場合、初期ページへリダイレクト
            return redirect()->route('register.team.index');
        }

        DB::transaction(function () use ($teamRegister) {
            // チーム登録
            $team = new Team();
            $team->name = $teamRegister->teamName;
            $team->sport_affiliation_type = $teamRegister->sportAffiliationType;
            $team->prefecture_code = $teamRegister->prefecture;
            $team->address = $teamRegister->address;
            $team->url = $teamRegister->teamUrl;
            $team->save();

            $teamRegister->tempFile->moveTo(); // 仮ディレクトリから正式ディレクトリへ移動

            // チーム画像保存
            $team->image()->save(new Image([
                'path' => $teamRegister->tempFile->path(),
                'extension' => $teamRegister->tempFile->extension(),
                'mime_type' => $teamRegister->tempFile->mimeType()
            ]));

            $team->code()->save(new Code([
                'code' => Str::uuid(),
                'expired_at' => Carbon::now()->addYear()
            ]));

            $user = User::find(Auth::id());

            // チームメンバーに保存
            $user->teamMember()->save(new TeamMember([
                'team_id' => $team->id,
                'user_id' => $user->id
            ]));
        });

        return redirect()->route('team.list');
    }
}
