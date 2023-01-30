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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * チームメンバ登録
     *
     * @param int $userId
     * @param int $teamId
     * @return void
     */
    public function registerTeamMember($userId, $teamId)
    {
        return $this->create([
            'user_id' => $userId,
            'team_id' => $teamId,
        ]);
    }

    /**
     * 登録後のユーザ情報を取得
     *
     * @param object $teamMember
     * @return object
     */
    public function getUserByTeamIdAndUserId($teamMember)
    {
        $query = $this->where([
            'user_id' => $teamMember->user_id,
            'team_id' => $teamMember->team_id,
        ]);
        return $query->with(['user', 'team'])->first();
    }

    /**
     * ユーザidから自チーム情報を取得
     *
     * @param int $userId
     * @return object
     */
    public function getTeamByUserId($userId)
    {
        $query = $this->where('user_id', '=', $userId);
        $team = $query->with('team')->first();

        return $team;
    }
}
