<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsentGameIdRequest;
use App\Http\Requests\ConsentGameReplyMessageRequest;
use App\Models\ConsentGame;
use App\Models\Message;
use App\Models\Reply;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class ConsentGameReplyController extends Controller
{
    /**
     * 招待された試合の詳細画面
     *
     * @param ConsentGameIdRequest $request
     * @param string $consent_game_id
     * @return \Inertia\Response
     */
    public function detail(ConsentGameIdRequest $request, string $consent_game_id): Response
    {
        $myTeam = Team::whereRelation('team_members', 'user_id', Auth::id())->firstOrFail();
        $consentGame = ConsentGame::whereHas('invitee')
                    ->whereHas('guest')
                    ->where('id', $consent_game_id)
                    ->with([
                        'invitee',
                        'guest',
                        'replies.message'
                    ])->firstOrFail();

        return Inertia::render('ConsentGame/ConsentDetail', [
            'myTeam' => [
                'id' => $myTeam->id,
                'name' => $myTeam->name,
                'image_path' => $myTeam->image->getPathBase64Attribute()
            ],
            'consentGame' => [
                'id' => $consentGame->id,
                'invitee' => [
                    'id' => $consentGame->invitee->id,
                    'name' => $consentGame->invitee->name,
                    'image_path' => $consentGame->invitee->image->getPathBase64Attribute()
                ],
                'guest' => [
                    'id' => $consentGame->guest->id,
                    'name' => $consentGame->guest->name,
                    'image_path' => $consentGame->guest->image->getPathBase64Attribute()
                ],
                'consent_status' => $consentGame->consent_status->label(),
                'replies' => $consentGame->replies->map(fn($reply) => [
                    'id' => $reply->id,
                    'message' => $reply->message->message,
                    'created_at' => $reply->created_at,
                    'team_id' => $reply->team_id,
                ]),
                'game_date' => $consentGame->game_date,
                'first_preferered_date' => $consentGame->first_preferered_date,
                'second_preferered_date' => $consentGame->second_preferered_date,
                'third_preferered_date' => $consentGame->third_preferered_date
            ]
        ]);
    }

    public function index()
    {

    }

    public function confirm()
    {

    }

    public function back()
    {

    }

    public function complete()
    {

    }

    /**
     * 招待された試合への返信
     *
     * @param ConsentGameReplyMessageRequest $request
     * @param string $consent_game_id
     * @return RedirectResponse
     */
    public function replyMessage(ConsentGameReplyMessageRequest $request, string $consent_game_id): RedirectResponse
    {
        $validated = $request->validated();
        $consentGame = ConsentGame::findOrFail($consent_game_id);

        try {
            $reply = new Reply();
            $reply->consent_game_id = $consentGame->id;
            $reply->team_id = Team::whereRelation('team_members', 'user_id', Auth::id())->firstOrFail()->id;
            $reply->save();
            $reply->message()->create([
                'message' => $validated['message']
            ]);
        } catch (\Exception $e) {
            Log::error('Reply registration failed: ' . $e->getMessage());
            return redirect()->route('myteam.consent_game.detail', [
                'consent_game_id' => $consent_game_id
            ])->withErrors(['reply' => __('messages.error.registered')]);
        }

        return redirect()->route('myteam.consent_game.detail', [
            'consent_game_id' => $consent_game_id
        ]);
    }
}
