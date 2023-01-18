<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'team_id',
    ];

    public function registerTeamMember($userId, $teamId)
    {
        $this->insert([
            'user_id' => $userId,
            'team_id' => $teamId,
        ]);
    }
}
