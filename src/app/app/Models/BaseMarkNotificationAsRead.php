<?php
declare(strict_types=1);
namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Log;

class BaseMarkNotificationAsRead
{
    /**
     * 未読の通知を更新
     *
     * @param \Illuminate\Database\Eloquent\Model|null $notification
     * @return void
     */
    public static function markAsRead(?\Illuminate\Database\Eloquent\Model $notification): void
    {
        if ($notification && is_null($notification->read_at)) {
            $notification->read_at = CarbonImmutable::now();
            $notification->save();
            Log::channel('job')->info("既読更新 通知ID: {$notification->id}");
        }
    }
}
