<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsentGamesController extends Controller
{
    private $team;

    public function __construct(Team $team)
    {
        $this->team = $team;
    }

    public function index($invitation_code)
    {
        // 招待先のチーム情報と招待情報の取得
        // 招待中は、表示を招待中に変更
        $guestTeam = $this->team->getTeamInfoByInvitationCodeWithConsents($invitation_code);
        dd($guestTeam);

        return view('consentGames.index', compact('guestTeam'));
    }
}
