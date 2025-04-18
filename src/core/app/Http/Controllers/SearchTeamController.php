<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * チームを検索する
 */
class SearchTeamController extends Controller
{
    /**
     * ログイン後、自チームの登録住所(都道府県のチーム情報を表示)
     * 検索クエリを加えて、その検索結果を表示
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $values = $request->only(['prefecture', 'address']);
        $prefecture = "";
        $address = "";

        $userId = Auth::user()->id;
        $myTeam = TeamMember::getTeamByUserId($userId);
        $teams = Team::getTeamBySearchQuery($myTeam, $values);

        if (isset($values['prefecture'])) {
            $teams->appends(['prefecture' => $values['prefecture']]);
            $prefecture = $values['prefecture'];
        }

        if (isset($values['address'])) {
            $teams->appends(['address' => $values['address']]);
            $address = $values['address'];
        }

        return view('searchTeam.index', compact('teams', 'prefecture', 'address', 'myTeam'));
    }
}
