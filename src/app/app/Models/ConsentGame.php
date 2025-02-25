<?php

namespace App\Models;

use App\Enums\ConsentStatusTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;

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

    public function replies()
    {
        return $this->hasMany(Reply::class, 'consent_game_id');
    }

    public function invitee()
    {
        return $this->belongsTo(Team::class, 'invitee_id');
    }

    public function guest()
    {
        return $this->belongsTo(Team::class, 'guest_id');
    }

    public function comment() : morphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
