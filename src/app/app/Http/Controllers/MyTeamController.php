<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MyTeamController extends Controller
{
    public function index()
    {
        return Inertia::render('MyTeam/Index');
    }
}
