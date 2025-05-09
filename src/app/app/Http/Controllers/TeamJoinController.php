<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Requests\TeamJoinRequest;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class TeamJoinController extends Controller
{
    /**
     * 入力画面
     *
     * @return \Inertia\Response
     */
    public function index(): Response
    {
        return Inertia::render('Register/TeamJoinRegistrationForm', [
            'routes' => [
                'select' => route('register.team.select'),
                'confirm' => route('register.team.join.confirm'),
            ]
        ]);
    }

    /**
     * 確認画面
     *
     * @param TeamJoinRequest $request
     * @return \Inertia\Response
     */
    public function confirm(TeamJoinRequest $request): Response
    {
        session(['invitation_code' => $request->validated('invitation_code')]);
        $team = Team::whereRelation('code', 'code', '=', $request->validated('invitation_code'))->firstOrFail();

        return Inertia::render('Register/TeamJoinRegistrationConfirm', [
            'team' => [
                'name' => $team->name,
            ],
            'routes' => [
                'complete' => route('register.team.join.complete'),
                'back' => route('register.team.join.back'),
            ],
        ]);
    }


    /**
     * 確認画面から入力画面へ戻り
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back(): RedirectResponse
    {
        session()->forget('invitation_code');
        return redirect()->route('register.team.join.index');
    }

    /**
     * 完了処理
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function complete(Request $request): RedirectResponse
    {
        $team = Team::whereRelation('code', 'code', '=', $request->session()->pull('invitation_code'))->firstOrFail();

        // チームにユーザを追加
        $team->team_members()->create([
            'user_id' => Auth::id(),
            'team_id' => $team->id,
        ]);
        return redirect()->route('team.list');
    }
}
