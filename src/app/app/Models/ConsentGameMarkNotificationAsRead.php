<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Support\Facades\Log;

class ConsentGameMarkNotificationAsRead extends BaseMarkNotificationAsRead
{
    /**
     * 通知された試合招待とユーザに対する既読処理
     *
     * @return void
     */
    public static function consentGameMarkAsRead(string $consent_game_id, string $user_id): void
    {
        Log::channel('job')->info('【既読処理開始】');
        $consentGame = ConsentGame::where('id', $consent_game_id)
            ->with([
                'replies.message.notification' => function ($query) use ($user_id) {
                    $query->where('senderable_type', User::class);
                    $query->where('senderable_id', $user_id);
                    $query->whereNull('read_at');
                },
                'notification' => function ($query) use ($consent_game_id, $user_id) {
                    $query->where('senderable_type', User::class);
                    $query->where('senderable_id', $user_id);
                    $query->whereNull('read_at');
                }
            ])->firstOrFail();

        // 招待の返信に対する既読処理
        Log::channel('job')->info("ユーザID: {$user_id}");
        self::markAsRead($consentGame->notification);

        foreach ($consentGame->replies as $reply) {
            // 返信メッセージの既読処理
            self::markAsRead($reply->message?->notification);
        }
        Log::channel('job')->info('【既読処理終了】');
    }
}
