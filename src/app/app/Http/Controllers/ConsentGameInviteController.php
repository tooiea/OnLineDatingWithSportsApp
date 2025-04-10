<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Enums\ConsentStatusTypeEnum;
use App\Http\Requests\ConsentGameInviteRequest;
use App\Http\Requests\ConsentGameTeamIdRequest;
use App\Models\ConsentGame;
use App\Models\ConsentGameInvite;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ConsentGameInviteController extends Controller
{
    /**
     * 試合招待画面
     *
     * @param string $team_id
     * @return Response
     */
    public function index(ConsentGameTeamIdRequest $request, string $team_id): Response
    {
        $guestTeam = Team::findOrFail($team_id);
        return Inertia::render('ConsentGame/GameInviteForm', [
            'guestTeam' => [
                'id' => $guestTeam->id,
                'name' => $guestTeam->name,
                'url' => $guestTeam->url,
                'image_path' => $guestTeam->image->getPathBase64Attribute(),
            ],
            'old' => session()->getOldInput(),
        ]);
    }

    /**
     * 招待内容確認画面
     *
     * @param ConsentGameInviteRequest $request
     * @param string $team_id
     * @return Response
     */
    public function confirm(ConsentGameInviteRequest $request, string $team_id): Response
    {
        session(['consent_game_invite' => new ConsentGameInvite(
            first_preferered_date: $request->validated('first_preferered_date'),
            second_preferered_date: $request->validated('second_preferered_date'),
            third_preferered_date: $request->validated('third_preferered_date'),
            message: $request->validated('message'),
        )]);
        $guestTeam = Team::findOrFail($team_id);
        return Inertia::render('ConsentGame/GameInviteConfirm', [
            'first_preferered_date' => $request->validated('first_preferered_date'),
            'second_preferered_date' => $request->validated('second_preferered_date'),
            'third_preferered_date' => $request->validated('third_preferered_date'),
            'message' => $request->validated('message'),
            'team_id' => $guestTeam->id,
        ]);
    }

    /**
     * 入力画面へ戻る
     *
     * @param ConsentGameTeamIdRequest $request
     * @param string $team_id
     * @return RedirectResponse
     */
    public function back(ConsentGameTeamIdRequest $request, string $team_id): RedirectResponse
    {
        $ConsentGameInvite = $request->session()->get('consent_game_invite');
        $values = $ConsentGameInvite? $ConsentGameInvite->getAll() : [];
        $guestTeam = Team::findOrFail($team_id);
        return redirect()->route('team.invite_game.index', [
            'team_id' => $guestTeam->id,
        ])->withInput($values);
    }

    /**
     * 招待完了画面
     *
     * @param ConsentGameTeamIdRequest $request
     * @param string $team_id
     * @return RedirectResponse
     */
    public function complete(ConsentGameTeamIdRequest $request, string $team_id): RedirectResponse
    {
        $consentGameInvite = $request->session()->pull('consent_game_invite');
        if (is_null($consentGameInvite)) {
            return redirect()->route('team.invite_game.index', [
                'team_id' => $team_id,
            ]);
        }

        $myTeam = Team::whereRelation('team_members', 'user_id', Auth::id())->first();
        $guestTeam = Team::findOrFail($team_id);

        $consentGame = new ConsentGame();
        $consentGame->invitee_id = $myTeam->id;
        $consentGame->guest_id = $team_id;
        $consentGame->consent_status = ConsentStatusTypeEnum::WAIT;
        $consentGame->first_preferered_date = $consentGameInvite->first_preferered_date;
        $consentGame->second_preferered_date = $consentGameInvite->second_preferered_date;
        $consentGame->third_preferered_date = $consentGameInvite->third_preferered_date;
        $consentGame->message = $consentGameInvite->message;
        $consentGame->save();

        $request->session()->flash('flash_message', $guestTeam->name . __('messages.success.consent_sent'));
        return redirect()->route('myteam.index');
    }
}
