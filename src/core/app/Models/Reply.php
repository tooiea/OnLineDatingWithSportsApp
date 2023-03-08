<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $fillable = [
        'consent_game_id',
        'message',
    ];

    /**
     * 返信内容を新規登録
     *
     * @param int $consent_games_id
     * @param array $customValues
     * @return void
     */
    public function createReply($consent_games_id, $customValues)
    {
        $values = [
            'consent_game_id' => $consent_games_id,
            'message' => '',
        ];

        if (isset($customValues['message'])) {
            $values['message'] = $customValues['message'];
        }

        $this->create($values);
    }
}
