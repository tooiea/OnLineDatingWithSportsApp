<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TempTeamRegisterController extends Controller
{
    public function index()
    {
        return view('temp-team.index');
    }

    public function confirm()
    {
        return view('temp_team_register.confirm');
    }

    public function complete()
    {
        return view('temp_team_register.complete');
    }
}