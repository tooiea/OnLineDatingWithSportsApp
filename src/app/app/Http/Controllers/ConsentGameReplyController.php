<?php

namespace App\Http\Controllers;

use App\Enums\ConsentStatusTypeEnum;
use App\Http\Requests\ConsentGameIdRequest;
use App\Http\Requests\ConsentGameReplyMessageRequest;
use App\Http\Requests\ConsentGameReplyRequest;
use App\Models\ConsentGame;
use App\Models\ConsentGameReply;
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
                'consent_status' => $consentGame->consent_status,
                'consent_status_label' => $consentGame->consent_status->label(),
                'replies' => $consentGame->replies->map(fn($reply) => [
                    'id' => $reply->id,
                    'message' => $reply->message? $reply->message->message : null,
                    'created_at' => $reply->created_at,
                    'team_id' => $reply->team_id,
                ]),
                'game_date' => $consentGame->game_date,
                'first_preferered_date' => $consentGame->first_preferered_date,
                'second_preferered_date' => $consentGame->second_preferered_date,
                'third_preferered_date' => $consentGame->third_preferered_date,
                'message' => $consentGame->message,
                'created_at' => $consentGame->created_at,
            ]
        ]);
    }

    /**
     * 招待された試合への返信画面
     *
     * @param ConsentGameIdRequest $request
     * @param string $consent_game_id
     * @return \Inertia\Response
     */
    public function index(ConsentGameIdRequest $request, string $consent_game_id): Response
    {
        $consentGame = ConsentGame::with(['invitee', 'guest'])->where('id', $consent_game_id)->firstOrFail();
        return Inertia::render('ConsentGame/ConsentReplyForm', [
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
                'game_date' => $consentGame->game_date,
                'first_preferered_date' => $consentGame->first_preferered_date,
                'second_preferered_date' => $consentGame->second_preferered_date,
                'third_preferered_date' => $consentGame->third_preferered_date,
                'message' => $consentGame->message,
            ],
            'replyStatuses' => ConsentStatusTypeEnum::replyList(),
            'old' => session()->getOldInput(),
        ]);
    }

    /**
     * 招待された試合への返信確認画面
     *
     * @param ConsentGameReplyRequest $request
     * @param string $consent_game_id
     * @return \Inertia\Response
     */
    public function confirm(ConsentGameReplyRequest $request, string $consent_game_id): Response
    {
        $consentGame = ConsentGame::findorFail($consent_game_id);
        session(['consent_game_reply' => new ConsentGameReply(
            first_preferered_date: $request->validated('first_preferered_date'),
            second_preferered_date: $request->validated('second_preferered_date'),
            third_preferered_date: $request->validated('third_preferered_date'),
            message: $request->validated('message'),
        )]);

        $myTeam = Team::whereRelation('team_members', 'user_id', Auth::id())->firstOrFail();
        $opponentTeam = $consentGame->invitee()->where('id', '!=', $myTeam->id)->first() ?? $consentGame->guest()->where('id', '!=', $myTeam->id)->first();
        return Inertia::render('ConsentGame/ConsentReplyConfirm', [
            'form' => [
                'first_preferered_date' => ConsentStatusTypeEnum::from($request->validated('first_preferered_date'))->replyLabel(),
                'second_preferered_date' => ConsentStatusTypeEnum::from($request->validated('second_preferered_date'))->replyLabel(),
                'third_preferered_date' => $request->validated('third_preferered_date') ? ConsentStatusTypeEnum::from($request->validated('third_preferered_date'))->replyLabel() : null,
                'message' => $request->validated('message'),
            ],
            'consent_game' => [
                'id' => $consentGame->id,
                'team_name' => $opponentTeam->name,
                'first_preferered_date' => $consentGame->first_preferered_date,
                'second_preferered_date' => $consentGame->second_preferered_date,
                'third_preferered_date' => $consentGame->third_preferered_date,
            ],
        ]);
    }

    /**
     * 招待された試合への返信入力画面へ戻る
     *
     * @param ConsentGameIdRequest $request
     * @param string $consent_game_id
     * @return RedirectResponse
     */
    public function back(ConsentGameIdRequest $request, string $consent_game_id): RedirectResponse
    {
        $form = session()->pull('consent_game_reply');
        $values = $form ? $form->getAll() : [];
        return redirect()->route('myteam.consent_game.reply.index', [
            'consent_game_id' => $consent_game_id
        ])->withInput($values);
    }

    /**
     * 招待された試合への返信登録
     *
     * @param ConsentGameIdRequest $request
     * @param string $consent_game_id
     * @return RedirectResponse
     */
    public function complete(ConsentGameIdRequest $request, string $consent_game_id): RedirectResponse
    {
        try {
            $form = session()->pull('consent_game_reply');
            $values = $form ? $form->getAll() : [];

            if (empty($values)) {
                return redirect()->route('myteam.consent_game.reply.index', [
                    'consent_game_id' => $consent_game_id
                ]);
            }

            $consentGame = ConsentGame::with(['invitee', 'guest'])->findOrFail($consent_game_id);
            if (! empty($form->getPreferedDate())) {
                $consentGame->game_date = $consentGame->{$form->getPreferedDate()} ?? null;
            }
            $consentGame->consent_status = $form->getStatus();
            $consentGame->save();

            $myTeam = Team::whereRelation('team_members', 'user_id', Auth::id())->firstOrFail();
            $opponentTeam = $consentGame->invitee()->where('id', '!=', $myTeam->id)->first() ?? $consentGame->guest()->where('id', '!=', $myTeam->id)->first();

            $reply = new Reply();
            $reply->consent_game_id = $consentGame->id;
            $reply->team_id = $myTeam->id;
            $reply->save();

            // メッセージがあれば登録
            $values['message'] ? $reply->message()->create(['message' => $values['message']]) : null;
            session()->flash('flash_message', $opponentTeam->name . __('messages.success.reply'));
        } catch (\Exception $e) {
            Log::error('Reply registration failed: ' . $e->getMessage());
            return redirect()->route('myteam.consent_game.detail', [
                'consent_game_id' => $consent_game_id
            ])->withErrors(['reply' => __('messages.error.registered')]);
        }

        return redirect()->route('myteam.index');
    }

    /**
     * 招待された試合へのメッセージ返信
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
