<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Enums\Prefecture;
use App\Enums\SportAffiliationTypeEnum;
use App\Http\Requests\TempTeamRegisterRequest;
use App\Models\Code;
use App\Models\Image;
use App\Models\TempFile;
use App\Models\TempTeamRegister;
use App\Models\TempUser;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TempTeamRegisterController extends Controller
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
        ]);
    }

    /**
     * 確認画面
     *
     * @param TempTeamRegisterRequest $request
     * @return \Inertia\Response
     */
    public function confirm(TempTeamRegisterRequest $request): Response
    {
        // 入力画像を保存
        $tempFile = new TempFile($request->file('teamLogo'));
        $tempTeamRegister = new TempTeamRegister(
            nickname: $request->validated('nickname'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            password2: $request->validated('password2'),
            sportAffiliationType: (int)$request->validated('sportAffiliationType'),
            teamName: $request->validated('teamName'),
            tempFile: $tempFile,
            teamUrl: $request->validated('teamUrl'),
            prefecture: (int)$request->validated('prefecture'),
            address: $request->validated('address')
        );
        // セッションへ保存
        session(['temp_team_register.form' => $tempTeamRegister]);
        return Inertia::render('Register/TeamRegistrationConfirm', [
            'sportAffiliationType' => $request->validated('sportAffiliationType'),
            'sportAffiliationLabel' => SportAffiliationTypeEnum::from((int)$request->validated('sportAffiliationType'))->label(),
            'teamName' => $request->validated('teamName'),
            'teamLogoUrl' => $tempFile->pathFromBase64(),
            'teamUrl' => $request->validated('teamUrl'),
            'prefecture' => $request->validated('prefecture'),
            'prefectureLabel' => Prefecture::from((int)$request->validated('prefecture'))->label(),
            'address' => $request->validated('address'),
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
        $form = $request->session()->pull('temp_team_register.form');

        if (is_null($form)) {
            // セッションに値がない場合、初期ページへリダイレクト
            return redirect()->route('temp_register.team.index');
        }
        $tempTeamRegister = $form->getAll();
        $tempFile = $tempTeamRegister['tempFile'];
        $tempFile->delete(); // 仮保存ファイルの削除
        return redirect()->route('temp_register.team.index')->withInput($tempTeamRegister);
    }

    /**
     * 完了画面
     *
     * @param Request $request
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function complete(Request $request): Response|RedirectResponse
    {
        $form = $request->session()->pull('temp_team_register.form');

        if (is_null($form)) {
            // セッションに値がない場合、初期ページへリダイレクト
            return redirect()->route('temp_register.team.index');
        }

        $tempTeamRegister = $form->getAll();
        DB::transaction(function () use ($tempTeamRegister) {
            $uuid = Str::uuid();

            // 仮登録情報を保存
            $tempUser = new TempUser();
            $tempUser->nickname = $tempTeamRegister['nickname'];
            $tempUser->email = $tempTeamRegister['email'];
            $tempUser->password = Hash::make($tempTeamRegister['password']);
            $tempUser->sport_affiliation_type = $tempTeamRegister['sportAffiliationType'];
            $tempUser->team_name = $tempTeamRegister['teamName'];
            $tempUser->team_url = $tempTeamRegister['teamUrl'];
            $tempUser->prefecture_code = $tempTeamRegister['prefecture'];
            $tempUser->address = $tempTeamRegister['address'];
            $tempUser->save();

            // チーム画像を保存
            $tempUser->image()->save(new Image([
                'path' => $tempTeamRegister['tempFile']->path(),
                'extension' => $tempTeamRegister['tempFile']->extension(),
                'mime_type' => $tempTeamRegister['tempFile']->mimeType()
            ]));

            // 本登録用の認証コード
            $tempUser->code()->save(new Code([
                'code' => $uuid,
                'expired_at' => Carbon::now()->addHour()
            ]));
            $tempUser->temporaryRegistrationNotification($uuid, config('mail.from.address'));
        });

        return Inertia::render('Register/TeamRegistrationComplete');
    }
}
