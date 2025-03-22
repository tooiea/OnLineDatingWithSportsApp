<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ConsentGame;
use App\Models\Team;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $id
 * @property string $consent_game_id
 * @property string $team_id
 * @property Carbon $created_at
 * @property Carbon $update_at
 * @property ConsentGame $consent_game
 * @property Team $team
 */
class Reply extends Model
{
    use Notifiable, HasFactory, HasUuids;

    protected $fillable = [
        'consent_game_id',
        'team_id',
    ];

    public function consent_game()
    {
        return $this->belongsTo(ConsentGame::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function comment() : MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
