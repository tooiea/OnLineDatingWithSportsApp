<?php
declare(strict_types=1);
namespace App\Models;

use App\Enums\ConsentStatusTypeEnum;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

/**
 * @property string $id
 * @property string $invitee_id
 * @property string $guest_id
 * @property ConsentStatusTypeEnum $consent_status
 * @property Carbon $game_date
 * @property Carbon $first_preferered_date
 * @property Carbon $second_preferered_date
 * @property Carbon $third_preferered_date
 * @property Carbon $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Reply $replies
 * @property Team $invitee
 * @property Team $guest
 */
class ConsentGame extends Model
{
    use HasUuids, HasFactory, Notifiable;

    protected $fillable = [
        'invitee_id',
        'guest_id',
        'consent_status',
        'game_date',
        'first_preferered_date',
        'second_preferered_date',
        'third_preferered_date',
        'message',
        'deleted_at',
    ];

    protected $casts = [
        'consent_status' => ConsentStatusTypeEnum::class,
    ];

    /**
     * 返信
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'consent_game_id');
    }

    /**
     * 招待者
     *
     * @return BelongsTo
     */
    public function invitee(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'invitee_id');
    }

    /**
     * ゲスト
     *
     * @return BelongsTo
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'guest_id');
    }

    /**
     * 試合招待通知(招待、返事)
     *
     * @return MorphOne
     */
    public function notification(): MorphOne
    {
        return $this->morphOne(Notification::class, 'notifiable');
    }

    /**
     * コメント
     *
     * @return morphMany
     */
    public function message() : morphMany
    {
        return $this->morphMany(Message::class, 'messageable');
    }

    /**
     * My Teamで招待したチーム情報を取得する
     *
     * @param int $teamId
     * @return object
     */
    public static function getMyTeamInvites($teamId)
    {
        $now = CarbonImmutable::now();
        return self::where('invitee_id', $teamId)
                ->where(function ($query) use ($now) {
                    $query->orwhere('first_preferered_date', '>=', $now);
                    $query->orwhere('second_preferered_date', '>=', $now);
                    $query->orwhere('third_preferered_date', '>=', $now);
                })
                ->whereHas('guest')
                ->with([
                    'guest.image',
                    'notification' => function ($query) {
                        $query->where('senderable_type', User::class);
                        $query->where('senderable_id', Auth::id());
                        $query->whereNull('read_at');
                    },
                    'replies.message.notification' => function ($query) {
                        $query->where('senderable_type', User::class);
                        $query->where('senderable_id', Auth::id());
                        $query->whereNull('read_at');
                    },
                ])
                ->orderByRaw("
                    LEAST(
                        first_preferered_date,
                        COALESCE(second_preferered_date, '9999-12-31'),
                        COALESCE(third_preferered_date, '9999-12-31')
                    ) ASC
                ")->get()
                ->map(fn ($invite) => [
                    'id' => $invite->id,
                    'created_at' => $invite->created_at,
                    'consent_status' => $invite->consent_status,
                    'consent_status_label' => $invite->consent_status->label(),
                    'game_date' => $invite->game_date,
                    'first_preferered_date' => $invite->first_preferered_date,
                    'second_preferered_date' => $invite->second_preferered_date,
                    'third_preferered_date' => $invite->third_preferered_date,
                    'unread' => self::hasUnreadNotification($invite),
                    'team' => [
                        'id' => $invite->guest->id,
                        'name' => $invite->guest->name,
                        'image' => $invite->guest->image ? [
                            'path_base64' => $invite->guest->image->path_base64,
                        ] : null,
                    ],
                ]);
    }

    /**
     * ゲスト側で招待のあったチーム情報を取得
     *
     * @param int $teamId
     * @return object
     */
    public static function getAsGuestInvites($teamId)
    {
        $now = CarbonImmutable::now();
        return self::where('guest_id', $teamId)
                ->where(function ($query) use ($now) {
                    $query->orwhere('first_preferered_date', '>=', $now);
                    $query->orwhere('second_preferered_date', '>=', $now);
                    $query->orwhere('third_preferered_date', '>=', $now);
                })
                ->whereHas('invitee')
                ->with([
                    'invitee.image',
                    'notification' => function ($query) {
                        $query->where('senderable_type', User::class);
                        $query->where('senderable_id', Auth::id());
                        $query->whereNull('read_at');
                    },
                    'replies.message.notification' => function ($query) {
                            $query->where('senderable_type', User::class);
                            $query->where('senderable_id', Auth::id());
                            $query->whereNull('read_at');
                    },
                ])
                ->orderByRaw("
                    LEAST(
                        first_preferered_date,
                        COALESCE(second_preferered_date, '9999-12-31'),
                        COALESCE(third_preferered_date, '9999-12-31')
                    ) ASC
                ")->get()
                ->map(fn ($invite) => [
                    'id' => $invite->id,
                    'created_at' => $invite->created_at,
                    'consent_status' => $invite->consent_status,
                    'consent_status_label' => $invite->consent_status->label(),
                    'game_date' => $invite->game_date,
                    'first_preferered_date' => $invite->first_preferered_date,
                    'second_preferered_date' => $invite->second_preferered_date,
                    'third_preferered_date' => $invite->third_preferered_date,
                    'unread' => self::hasUnreadNotification($invite),
                    'team' => [
                        'id' => $invite->invitee->id,
                        'name' => $invite->invitee->name,
                        'image' => $invite->invitee->image ? [
                            'path_base64' => $invite->invitee->image->path_base64,
                        ] : null,
                    ],
                ]);
    }

    /**
     * 未読の通知があるか
     *
     * @param ConsentGame $invite
     * @return boolean
     */
    public static function hasUnreadNotification(ConsentGame $invite): bool
    {
        if (!empty($invite->notification)) {
            return true;
        }

        foreach ($invite->replies as $reply) {
            if ($reply->message && $reply->message->notification) {
                return true;
            }
        }

        return false;
    }
}
