<?php

namespace App\Http\Controllers;

use App\Http\Requests\TempTeamUserRequest;
use Illuminate\Http\Request;

class TempTeamUsersController extends Controller
{
    public function index()
    {
        return view('tempTeamUsers.index');
    }

    public function confirm(TempTeamUserRequest $request)
    {
        $values = $request->input();
        session(['temp_team_users' => $values]);
        return view('tempTeamUsers.confirm');
    }

    public function complete(Request $request)
    {
        $formInputs = $request->session()->pull('temp_team_users');
        return view('tempTeamUsers.complete');
    }
}
