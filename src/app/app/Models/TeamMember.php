<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $team_id
 * @property string $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Team $team
 * @property User $user
 */
class TeamMember extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'user_id',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
